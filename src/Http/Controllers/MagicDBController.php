<?php

namespace Flamento\MagicDB\Http\Controllers;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;

class MagicDBController extends Controller
{
    public function loginIndex()
    {
        $this->validateLogin('guest');
        return view('magicdb::login');
    }

    public function login(Request $request)
    {
        $this->validateLogin('guest');
        $validated = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if ($validated['username'] !== config('magicdb.MAGICDB_USERNAME') || $validated['password'] !== config('magicdb.MAGICDB_PASSWORD')) {
            return redirect()->back()->withErrors(['username' => 'Username or password is incorrect'])->withInput();
        }
        session(['magicdb_login' => date('Y-m-d H:i:s')]);

        return redirect()->route('magicdb.index');
    }

    public function logout()
    {
        $this->validateLogin('auth');
        session()->forget('magicdb_login');
        return redirect()->route('magicdb.loginIndex');
    }

    public function index()
    {
        $this->validateLogin();

        //get all tables
        $tables = $this->getTables();
        //get total records count
        $totalRows = 0;
        foreach ($tables as $table) {
            $totalRows += DB::table($table)->count();
        }

        return view('magicdb::index', compact('tables'), compact('totalRows'));
    }

    private function getTables()
    {
        $tables = DB::select('SHOW TABLES');
        $tables = array_map(function ($table) {
            return array_values((array) $table)[0];
        }, $tables);
        return $tables;
    }

    public function showTable($tableName)
    {
        $this->validateLogin();
        //clear error and success session
        $totalRows = DB::table($tableName)->count();
        $tables = $this->getTables();

        try {
            $query = request('query');
            if ($query) {
                $query = explode(' ', $query)[0];
                if (in_array(strtolower($query), ['select', 'show', 'describe', 'explain'])) {
                    $records = DB::select(request('query'));
                    $columns = array_keys((array) $records[0]);

                    session()->flash('success', 'Query executed successfully >> \'' . request('query') . "'");

                    return view('magicdb::tables.show', compact('tableName', 'tables', 'records', 'columns', 'totalRows'));
                }

                /* Assume: Must be an update */
                DB::statement(request('query'));
                session()->flash('success', 'Query executed successfully >> \'' . request('query') . "'");

                return redirect()->route('magicdb.showTable', ['tableName' => $tableName, 'query' => '']);
            }
        } catch (Exception $e) {
            /* flash error message */
            session()->flash('error', $e->getMessage());
        }

        //check if user wants to select via query param, first word


        $records = DB::table($tableName)->paginate(request('perPage', 10));
        //get columnds from records[0]
        $columns = collect($records[0])->reduce(function ($carry, $item, $key) {
            $carry[] = $key;
            return $carry;
        }, []);

        return view('magicdb::tables.show', compact('tableName', 'tables', 'records', 'columns', 'totalRows'));
    }


    private function validateLogin($type = "auth")
    {

        if ($type === 'auth' && !session('magicdb_login')) {
            abort(401);
        }
        if ($type === 'guest' && session('magicdb_login')) {
            Redirect::route('magicdb.index')->send();
        }
    }

    public function mysqlBackup()
    {
        $this->validateLogin();

        $filename = "backup-" . now()->format('Y-m-d-H-i-s') . ".gz";
        $dir = storage_path('app/magicdb/backup');
        $path = $dir . '/' . $filename;

        //check if backup dir exists
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        $command = "mysqldump --user=" . env('DB_USERNAME') . " --password=" . env('DB_PASSWORD') . " --host=" . env('DB_HOST') . " " . env('DB_DATABASE') . "  | gzip > " . $path;

        $returnVar = NULL;
        $output  = NULL;
        try {
            $result = exec($command, $output, $returnVar);
            if ($returnVar == 0) {
                return response()->download($path);
            } else {
                return redirect()->back()->withErrors(['error' => 'MySQL Database Backup Failed', 'result' => $result, 'output' => $output, 'returnVar' => $returnVar]);
            }
        } catch (Exception $e) {
            return redirect()->back()->withErrors(['error' => $e->getMessage(),]);
        }
    }
}

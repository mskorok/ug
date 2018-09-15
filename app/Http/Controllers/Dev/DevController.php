<?php

namespace App\Http\Controllers\Dev;

use App\Http\Controllers\Controller;
use App\Http\Requests;
use App\Models\Users\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Class DevController
 * @package App\Http\Controllers\Dev
 */
class DevController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $con_msg = '';
        $pdo = null;
        try {
            $pdo = DB::connection()->getPdo();
        } catch (Exception $e) {
            $con_msg = $e->getMessage();
        }
        return view('dev.index', ['con_msg' => $con_msg, 'pdo' => $pdo]);
    }

    public function postDotenv()
    {
        $f = fopen('../.env', 'w');
        $prev_key_cat = '';
        if ($f) {
            foreach ($_ENV as $k => $v) {
                if ($prev_key_cat !== '' && $prev_key_cat !== explode('_', $k)[0]) {
                    fwrite($f, "\n");
                }
                $prev_key_cat = explode('_', $k)[0];

                fwrite($f, $k . '=' . $_POST[$k] . "\n");
            }
            fclose($f);
        } else {
            dd('error');
        }

        header('Location: /dev');
        exit;
    }

    public function copyDotenv()
    {
        if (!file_exists('../.env')) {
            copy('../.env.example', '../.env');
        }

        header('Location: /dev');
        exit;
    }

    public function generateAppKey()
    {
        exec('php ../artisan key:generate');
        header('Location: /dev');
        exit;
    }

    /**
     * @param $cmd
     */
    private function cli($cmd)
    {
        chdir('..');
        header('Content-Encoding: none;');
        set_time_limit(0);
        $handle = popen($cmd, "r");
        if (ob_get_level() == 0)
            ob_start();

        while(!feof($handle)) {

            $buffer = fgets($handle);
            $buffer = trim(htmlspecialchars($buffer));

            echo $buffer . "<br />";
            echo str_pad('', 4096);

            ob_flush();
            flush();
            sleep(1);
        }

        pclose($handle);
        ob_end_flush();
        echo '<a href="/dev">Go back</a>';
        exit;
    }

    public function composerInstall()
    {
        $this->cli("composer install 2>&1");
    }

    public function dbRebuild()
    {
        $this->cli('php artisan db:rebuild && php artisan migrate && php artisan db:seed');
    }
}

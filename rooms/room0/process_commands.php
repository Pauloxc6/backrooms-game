<?php
session_start();
include '../../includes/functions.php';

// Caminho para os arquivos simulados
define('SIMULATED_DB_PATH', './db/');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $command = $_POST['command'] ?? '';
    $level = $_POST['level'] ?? 1;
    $user_id = $_POST['user_id'] ?? 0;
    $output = ""; // Inicializa a variável de saída do comando

    // Simulação de arquivos para os comandos
    $files = [
        'file1.txt' => 'Não há aqui de relevante.',
        'file2.txt' => '',
        'file3.txt' => 'Arquivos ocultos podem conter informações úteis.',
    ];

    $files_ocultos = [
        '.users.txt' => 'admin',
        '.pass.txt' => 'admin',
    ];

    // Lista de comandos disponíveis e suas descrições
    $help_text = "Comandos disponíveis:\n"
                . "ls - Lista todos os arquivos.\n"
                . "ls -a - Lista todos os arquivos, incluindo ocultos.\n"
                . "cat <arquivo> - Exibe o conteúdo do arquivo especificado.\n"
                . "coletar <informação> - Coleta informação e a armazena.\n"
                . "db_mysql - Inicia o login simulado no banco de dados.\n"
                . "help - Mostra esta ajuda.";

    // Processar o comando
    if (trim($command) === 'ls') {
        // Lista todos os arquivos
        $output = implode("\n", array_keys($files));
    } elseif (trim($command) === 'ls -a') {
        // Lista todos os arquivos, incluindo os ocultos
        $output = implode("\n", array_merge(array_keys($files), array_keys($files_ocultos)));
    } elseif (strpos($command, 'cat ') === 0) {
        // Comando `cat` para exibir o conteúdo de um arquivo
        $filename = trim(substr($command, 4));
        if (array_key_exists($filename, $files)) {
            $output = $files[$filename];
        } elseif (array_key_exists($filename, $files_ocultos)) {
            $output = $files_ocultos[$filename];
        } else {
            $output = "Arquivo não encontrado.";
        }
    } elseif (strpos($command, 'coletar') !== false) {
        // Comando `coletar`
        $info = str_replace('coletar ', '', $command);
        if (saveExplorerData($user_id, $level, $info)){
            $output = "Informação coletada: " . htmlspecialchars($info);
	} else {
	    $output = "Falha ao coletar a informação.";
	}
    } elseif (trim($command) === 'db_mysql') {
        // Inicia o processo de login simulado
        $_SESSION['db_step'] = 'user';
        $output = "Digite o nome de usuário:";
    } elseif (isset($_SESSION['db_step'])) {
        // Processa os passos de login simulado
        if ($_SESSION['db_step'] === 'user') {
            $_SESSION['db_user'] = trim($command);
            $_SESSION['db_step'] = 'pass';
            $output = "Digite a senha:";
        } elseif ($_SESSION['db_step'] === 'pass') {
            $_SESSION['db_pass'] = trim($command);
            // Verifica as credenciais simuladas
            $credentials = file(SIMULATED_DB_PATH . 'users.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $valid = false;
            foreach ($credentials as $cred) {
                list($username, $password) = explode(':', trim($cred));
                if ($username === $_SESSION['db_user'] && $password === $_SESSION['db_pass']) {
                    $valid = true;
                    break;
                }
            }
            if ($valid) {
                $_SESSION['db_logged_in'] = true;
                $output = "Conectado ao banco de dados simulado com sucesso.";
                $_SESSION['db_step'] = null; // Limpa o passo de login
            } else {
                $output = "Credenciais inválidas.";
                unset($_SESSION['db_user']);
                unset($_SESSION['db_pass']);
                unset($_SESSION['db_step']);
            }
        }
    } elseif (isset($_SESSION['db_logged_in']) && $_SESSION['db_logged_in']) {
        // Executa comandos SQL simulados
        $sql = trim($command);
        if (stripos($sql, 'show tables') === 0) {
            // Simula o comando SHOW TABLES
            $data = file(SIMULATED_DB_PATH . 'tables.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
            $output = implode("\n", $data);
        } elseif (stripos($sql, 'select') === 0) {
            // Simula uma consulta SQL
            if (stripos($sql, 'from entidades_tb') !== false) {
                $data = file(SIMULATED_DB_PATH . 'entidades_tb.txt', FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
                $output = implode("\n", $data);
            } else {
                $output = "Tabela não encontrada.";
            }
        } else {
            $output = "Comando não reconhecido.";
        }
    } elseif (trim($command) === 'help') {
        // Mostra a ajuda
        $output = $help_text;
    } else {
        $output = "Comando não reconhecido.";
    }

    echo $output;
}


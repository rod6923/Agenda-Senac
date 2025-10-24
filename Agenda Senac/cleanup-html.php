<?php
// Script para remover arquivos HTML redundantes
// Execute este script após confirmar que todas as páginas PHP estão funcionando

$files_to_remove = [
    'dashboard.html',
    'agenda.html', 
    'colaboradores.html',
    'perfil.html',
    'relatorios.html',
    'notificacoes.html',
    'configuracoes.html',
    'ajuda.html',
    'minhas-solicitacoes.html',
    'minhas-reservas.html',
    'agenda-colaborador.html',
    'perfil-colaborador.html',
    'solicitar-acesso.html'
];

echo "Arquivos HTML que serão removidos:\n";
foreach ($files_to_remove as $file) {
    if (file_exists($file)) {
        echo "- $file\n";
    }
}

echo "\nPara remover os arquivos, descomente as linhas abaixo:\n";
echo "// unlink(\$file);\n";

// Descomente as linhas abaixo para remover os arquivos HTML
/*
foreach ($files_to_remove as $file) {
    if (file_exists($file)) {
        unlink($file);
        echo "Removido: $file\n";
    }
}
*/
?>

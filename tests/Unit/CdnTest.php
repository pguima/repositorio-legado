<?php

it('=> verifica se Bootstrap e jQuery estão incluídos no HTML', function () {
    // Simulação de um arquivo HTML carregado como string
    $html = file_get_contents('http://localhost/repositorio-legado/');

    // Verifica a presença do Bootstrap CSS
    expect($html)->toContain('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');

    // Verifica a presença do Bootstrap JS
    expect($html)->toContain('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');

    // Verifica a presença do jQuery
    expect($html)->toContain('https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
});

it('=> verifica se links Bootstrap e jQuery estão corretos', function () {

    $bootstrap_css = file_get_contents('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css');
    expect($bootstrap_css)->toContain('https://github.com/twbs/bootstrap/blob/main/LICENSE');

    $bootstrap_js = file_get_contents('https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js');
    expect($bootstrap_js)->toContain('https://github.com/twbs/bootstrap/blob/main/LICENSE');
    
    $jquery = file_get_contents('https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js');
    expect($jquery)->toContain('jQuery v3.7.1');

});

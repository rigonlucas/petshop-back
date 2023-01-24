<?php

namespace Core\Projeto\Salvar\Resolvers;

use Core\Modules\Generics\Ordination\AbstractOrdinationResolver;

class SalvarProjetoResolver extends AbstractOrdinationResolver
{
    /**
    * Mapeamento [campo na request => tabela.coluna
    **/
    protected array $colunas = [
        'exmplo_request_name' => 'tabela_x.data_cadastro',
    ];
    protected ?string $colunaPadrao = 'usuario_ocorrencia.data';

    public function getColunaPadrao(): string
    {
        return $this->colunaPadrao;
    }
}
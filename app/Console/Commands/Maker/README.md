# Comandos para gerar camadas da arquitetura

## Comandos básicos

Comando básico:

* artisan make-arch:{{COMANDO}} /Projeto/Salvar/SalvarProejto
* A criação dos arquivos considera o caminho básico:
    * core/Modules/

## Exemplos de utilizalção

Crie todos os arquivos dos casos de uso em apenas um comando.

* O objetivo deste é reduzir o tempo de deesenvolvimento ao ter que criar as layers básicas da arquitetura
* O principal atributo considera a seguinte estrutura:
    * Caminho da pasta do usecase <mark>desconsiderando</mark> dois níveis de pasta <mark>[core/Modules]</mark>
    * No comando abaixo a estrutura esta divida em:
        * <b>Caminho</b> do usecase <mark>Projeto/Salvar/</mark>
        * <b>Nome do usecase</b> <mark>SalvarProjeto</mark>
        * Lembre-se, os sufixos das classes serão gerados automaticamente
        * Ao criar a paginação já cria a classe de ordenação dinêmica

```shell
php artisan make-arch:usecase Projeto/Salvar/SalvarProjeto 
    --entities=projeto,edital 
    --gateways=projeto,entidade
    --collections=atividades
    --exceptions=BuscarProjetoDatabase,EditalNaoEncontrado
    --pagination=true
    --rules=BuscaAlgumaCoisaRule,BuscaAlgumaCoisa2Rule
```

## Exemplos de utilizalção

Crie todos os arquivos dos casos de uso de EXPORTAÇÃO em apenas um comando.

* Possui todos os recursos do principal
* Segue um padrão de exportação já definido

```shell
php artisan make-arch:exportacao Projeto/Salvar/SalvarProjeto 
    --entities=projeto,edital 
    --gateways=projeto,entidade
    --collections=atividades
    --exceptions=BuscarProjetoDatabase,EditalNaoEncontrado
    --pagination=true
    --rules=BuscaAlgumaCoisaRule,BuscaAlgumaCoisa2Rule
```

# Criação das classes separadamente:

Você pode criar cada layer da arquitetura separadamente

### Criar entidade

* Output:
    * <b>Projeto/Salvar/Entities/Projeto.php</b>

```shell
php artisan make-arch:entity Projeto/Salvar/Entities/Projeto

ou

php artisan make-arch:entity Projeto/Salvar/Projeto 
```

### Criar collection

* Output:
    * <b>Projeto/Salvar/Collections/ProjetoCollection.php</b>

```shell
php artisan make-arch:collection Projeto/Salvar/Projeto

php artisan make-arch:collection Projeto/Salvar/Collections/Projeto  
```

### Criar Enum error

* Output:
    * <b>Projeto/Salvar/Collections/ErrorCodeEnum.php</b>

```shell
php artisan make-arch:enum-error Projeto/Salvar/Enums/

ou

php artisan make-arch:enum-error Projeto/Salvar/
```

### Criar Enum error

* Ordenação:
    * <b>Projeto/Salvar/Resolvers/OrdenacaoDaListaResolver.php</b>

```shell
php artisan make-arch:enum-error Projeto/Salvar/Resolvers/OrdenacaoDaLista

ou

php artisan make-arch:enum-error Projeto/Salvar/OrdenacaoDaLista
```

### Criar Exception

* Output:
    * <b>Projeto/Salvar/Exceptions/BuscaProjetoDatabaseException.php</b>

```shell
php artisan make-arch:exception Projeto/Salvar/BuscaProjetoDatabase 

ou

php artisan make-arch:exception Projeto/Salvar/Exceptions/BuscaProjetoDatabase 
```

### Criar gateways

* Output:
    * <b>Projeto/Salvar/Gateways/ProjetoInterface.php</b>

```shell
php artisan make-arch:gateway Projeto/Salvar/Projeto 

ou

php artisan make-arch:gateway Projeto/Salvar/Gateways/Projeto 
```

### Criar output

* Output:
    * <b>Projeto/Salvar/Outputs/ProjetoOutput.php</b>

```shell
php artisan make-arch:output Projeto/Salvar/Projeto 

ou

php artisan make-arch:output Projeto/Salvar/Outputs/Projeto 
```

### Criar presenter simples

* Output:
    * <b>Projeto/Salvar/Presenters/SalvarProjetoPresenter.php</b>

```shell
php artisan make-arch:presenter Projeto/Salvar/SalvarProjeto

ou

php artisan make-arch:presenter Projeto/Salvar/SalvarProjeto/Presenters
```

### Criar rule

* Output:
    * <b>Projeto/Salvar/Rules/SalvarProjetoRule.php</b>

```shell
php artisan make-arch:rule Projeto/Salvar/SalvarProjeto 

ou

php artisan make-arch:rule Projeto/Salvar/Rules/SalvarProjeto

```

### Criar ruleset

* Output:
    * <b>Projeto/Salvar/Rulesets/SalvarProjetoRuleset.php</b>

```shell
php artisan make-arch:ruleset Projeto/Salvar/SalvarProjeto 

ou

php artisan make-arch:ruleset Projeto/Salvar/Ruleset/SalvarProjeto 
```
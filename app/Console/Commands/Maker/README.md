# Comandos para gerar camadas da arquitetura

## Comandos básicos

Comando básico:

* artisan make-clean:{{COMANDO}} /Projeto/Salvar/SalvarProejto
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
php artisan make-clean:usecase Projeto/Salvar/SalvarProjeto 
    --entities=projeto,edital 
    --gateways=projeto,entidade
    --collections=atividades
    --exceptions=BuscarProjetoDatabase,EditalNaoEncontrado
    --pagination=true
```

# Criação das classes separadamente:

Você pode criar cada layer da arquitetura separadamente

### Criar entidade

* Output:
    * <b>Projeto/Salvar/Entities/Projeto.php</b>

```shell
php artisan make-clean:entity Projeto/Salvar/Entities/Projeto

ou

php artisan make-clean:entity Projeto/Salvar/Projeto 
```

### Criar collection

* Output:
    * <b>Projeto/Salvar/Collections/ProjetoCollection.php</b>

```shell
php artisan make-clean:collection Projeto/Salvar/Projeto

php artisan make-clean:collection Projeto/Salvar/Collections/Projeto  
```

### Criar Enum error

* Output:
    * <b>Projeto/Salvar/Collections/ErrorCodeEnum.php</b>

```shell
php artisan make-clean:enum-error Projeto/Salvar/Enums/

ou

php artisan make-clean:enum-error Projeto/Salvar/
```

### Criar Exception

* Output:
    * <b>Projeto/Salvar/Exceptions/BuscaProjetoDatabaseException.php</b>

```shell
php artisan make-clean:exception Projeto/Salvar/BuscaProjetoDatabase 

ou

php artisan make-clean:exception Projeto/Salvar/Exceptions/BuscaProjetoDatabase 
```

### Criar gateways

* Output:
    * <b>Projeto/Salvar/Gateways/ProjetoInterface.php</b>

```shell
php artisan make-clean:gateway Projeto/Salvar/Projeto 

ou

php artisan make-clean:gateway Projeto/Salvar/Gateways/Projeto 
```

### Criar output

* Output:
    * <b>Projeto/Salvar/Outputs/ProjetoOutput.php</b>

```shell
php artisan make-clean:output Projeto/Salvar/Projeto 

ou

php artisan make-clean:output Projeto/Salvar/Outputs/Projeto 
```

### Criar presenter simples

* Output:
    * <b>Projeto/Salvar/Presenters/SalvarProjetoPresenter.php</b>

```shell
php artisan make-clean:presenter Projeto/Salvar/SalvarProjeto

ou

php artisan make-clean:presenter Projeto/Salvar/SalvarProjeto/Presenters
```

### Criar rule

* Output:
    * <b>Projeto/Salvar/Rules/SalvarProjetoRule.php</b>

```shell
php artisan make-clean:rule Projeto/Salvar/SalvarProjeto 

ou

php artisan make-clean:rule Projeto/Salvar/Rules/SalvarProjeto

```

### Criar ruleset

* Output:
    * <b>Projeto/Salvar/Rulesets/SalvarProjetoRuleset.php</b>

```shell
php artisan make-clean:ruleset Projeto/Salvar/SalvarProjeto 

ou

php artisan make-clean:ruleset Projeto/Salvar/Ruleset/SalvarProjeto 
```
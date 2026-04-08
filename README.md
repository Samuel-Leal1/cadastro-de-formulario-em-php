# Cadastro de Funcionários

Sistema web de cadastro de funcionários desenvolvido com **PHP** e **PostgreSQL**.

## Estrutura do Projeto

```
cadastro-funcionarios/
├── index.php          # Tela de Login
├── dashboard.php      # Tela de Cadastro (Tela 2)
├── listagem.php       # Listagem de Funcionários (Tela 3)
├── ver.php            # Detalhes do funcionário
├── logout.php         # Encerrar sessão
├── forgot.php         # Recuperar senha
├── schema.sql         # Script de criação do banco
├── css/
│   └── style.css      # Estilos globais
└── includes/
    ├── db.php         # Conexão PDO com PostgreSQL
    ├── auth.php       # Controle de sessão
    └── navbar.php     # Barra de navegação compartilhada
```

## Requisitos

- PHP 8.0+
- PostgreSQL 13+
- Extensão `pdo_pgsql` habilitada no PHP

## Configuração

### 1. Banco de dados

```sql
CREATE DATABASE cadastro_funcionarios;
```

Em seguida, execute o arquivo `schema.sql` no banco criado:

```bash
psql -U postgres -d cadastro_funcionarios -f schema.sql
```

### 2. Configurar conexão

Edite `includes/db.php` com suas credenciais:

```php
$host = 'localhost';
$dbname = 'cadastro_funcionarios';
$user = 'postgres';
$password = 'SUA_SENHA';
```

### 3. Executar o servidor

```bash
php -S localhost:8000
```

Acesse: [http://localhost:8000](http://localhost:8000)

## Credenciais padrão

| Usuário | Senha     |
|---------|-----------|
| admin   | password  |

> A senha padrão no `schema.sql` usa `password_hash` do PHP. Para gerar um novo hash:
> ```php
> echo password_hash('sua_senha', PASSWORD_DEFAULT);
> ```
> E atualize a tabela `usuarios`.

## Funcionalidades

- ✅ Login com autenticação segura (bcrypt)
- ✅ Cadastro de funcionários (Nome, Cargo, E-mail, Telefone, Situação)
- ✅ Listagem com busca e paginação
- ✅ Edição e exclusão de registros
- ✅ Visualização detalhada
- ✅ Controle de sessão
- ✅ Proteção contra SQL Injection via PDO + prepared statements

## Tecnologias

- PHP (sem frameworks)
- PostgreSQL
- HTML5 + CSS3 (sem frameworks CSS)
- PDO para acesso ao banco

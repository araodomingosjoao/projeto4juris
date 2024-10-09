# API Laravel com Jetstream - Teste Técnico 4Juris

Este projeto é uma API desenvolvida em Laravel para gerenciar empresas, usuários e clientes. Foi criado como parte de um teste técnico para a 4Juris. A API é protegida por autenticação de tokens e segue os princípios de CRUD com mapeamentos relacionais entre empresas, usuários e clientes.

## Funcionalidades

- **Laravel Jetstream (opção API)**: O Jetstream foi usado para gerenciar autenticação e registro de usuários.
- **Autenticação por Token de API**: Apenas usuários autenticados podem acessar a API.
- **Operações CRUD**: Implementadas para Empresas, Usuários e Clientes, com os devidos relacionamentos.
- **Paginação de API**: Suporte à paginação para grandes volumes de dados.
- **Tratamento de Erros**: Respostas de erro unificadas e claras em toda a API.
- **Regras de Negócio**: Os usuários podem interagir apenas com entidades pertencentes à sua própria empresa.
- **Transações de Banco de Dados**: Operações críticas são protegidas por transações para garantir a integridade dos dados.
- **Trait para CRUD Genérico**: Foi criada uma trait reutilizável para operações CRUD, minimizando duplicação de código.

## Requisitos

- PHP >= 8.0
- Laravel >= 9.0
- Composer
- MySQL
- Node >= 18.0.0

## Instalação

1. Clone o repositório:
   ```bash
   git clone https://github.com/araodomingosjoao/projeto4juris.git
2. Navegue até o diretório do projeto:
   ```bash
   cd projeto4juris
3. Instale as dependências:
   ```bash
   composer install
4. Instale as dependências:
   ```bash
   npm install
4. Build:
   ```bash
   npm build
5. Configure as variáveis de ambiente:
   ```bash
   cp .env.example .env
6. Execute as migrações:
   ```bash
   php artisan migrate
7. Popule o banco de dados (opcional):
   ```bash
    php artisan db:seed

## Endpoints

- ### Empresas
    - `GET /api/empresas`: Listar todas as empresas (com paginação)
    - `POST /api/empresas`: Criar uma nova empresa
    - `GET /api/empresas/{id}`: Obter detalhes de uma empresa específica
    - `PUT /api/empresas/{id}`: Atualizar uma empresa
    - `DELETE /api/empresas/{id}`: Excluir uma empresa

- ### Clientes
    - `GET /api/clientes`: Listar todas as clientes (com paginação)
    - `POST /api/clientes`: Criar uma nova cliente
    - `GET /api/clientes/{id}`: Obter detalhes de uma cliente específica
    - `PUT /api/clientes/{id}`: Atualizar uma cliente
    - `DELETE /api/clientes/{id}`: Excluir uma cliente

- ### Auth
    - `GET /api/logout`: Terminar sessão
    - `POST /api/login`: Autenticação

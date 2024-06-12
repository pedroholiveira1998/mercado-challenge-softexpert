# Mercado challenge SoftExpert

## Projeto Dockerizado com Backend, Frontend e Banco de Dados PostgreSQL

Este projeto utiliza o Docker Compose para orquestrar um ambiente de desenvolvimento que inclui um backend PHP, um frontend construído com React.js e Vite, e um banco de dados PostgreSQL.

## Pré-requisitos

Certifique-se de ter os seguintes softwares instalados em sua máquina:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)

## Instruções de Instalação

Siga os passos abaixo para configurar e iniciar o ambiente de desenvolvimento.

1. **Clone o repositório:**

   ```bash
   git clone https://github.com/pedroholiveira1998/mercado-challenge-softexpert.git
   cd mercado-challenge-softexpert/
   ```

2. **Crie um arquivo `.env`:**

   O projeto utiliza variáveis de ambiente para configurar os serviços. Crie um arquivo `.env` na raiz do projeto e preencha com as seguintes variáveis:

   ```bash
   # Configurações do Frontend
   FRONTEND_PORT=3000

   # Configurações do Backend
   BACKEND_PORT=8000

   # Configurações do Banco de Dados
   DB_HOST=database
   DB_PORT=5432
   DB_NAME=seu_nome_de_banco
   DB_USER=seu_usuario
   DB_PASSWORD=sua_senha
   DB_TIMEZONE=America/Sao_Paulo 
   ```
   Para esse passo também pode ser usado o seguinte comando na raíz do projeto:

   ```bash
   cp .env.example .env
   ```
   > **Nota:** Substitua os valores das variáveis com os dados apropriados para seu ambiente.

3. **Construa e inicie os containers:**

   > **IMPORTANTE:** Dependendo da versão do Docker Compose instalada em sua máquina, você pode precisar alterar a variável COMPOSE no Makefile. Se a sua versão for anterior à 1.29.0, substitua docker compose por docker-compose na variável COMPOSE.

   3.1 Para contruir todos os serviços, execute o comando abaixo na raiz do projeto:

   ```bash
   make build
   ```

   Este comando irá construir as imagens Docker e criar os containers.


   3.2 Em seguida, para subir os containers, execute o comando na raiz do projeto:

   ```bash
   make up
   ```

   Este comando irá subir os containers.

   3.3 Por último, para instalar o composer e criar as tabelas do banco, execute o comando na raiz do projeto:

   ```bash
   make setup
   ```

   Este comando irá instalar o composer e criar as tabelas do banco.

4. **Acesse os serviços:**

   - **Frontend**: Disponível em `http://localhost:${FRONTEND_PORT}`, onde `${FRONTEND_PORT}` é o valor configurado no seu `.env`.
   - **Backend**: Disponível em `http://localhost:${BACKEND_PORT}`, onde `${BACKEND_PORT}` é o valor configurado no seu `.env`.
   - **Banco de Dados**: Pode ser acessado via um cliente PostgreSQL utilizando `localhost` e a porta `${DB_PORT}`.

## Acesso ao Frontend

Se tudo deu certo você agora deve ser capaz de acessar o front pela url: `http://localhost:${FRONTEND_PORT}`

> **Nota:** Lembre-se de substituir ${FRONTEND_PORT} pela porta em que seu frontend está sendo executado.

Caso tenha apenas copiado o arquivo .env pode acessar diretamente pela url: [http://localhost:3000](http://localhost:3000).

> **IMPORTANTE:** Antes de criar um produto, é necessário ter um tipo associado a ele. Certifique-se de criar um tipo de produto primeiro, pois ele será necessário durante o processo de criação do produto. Isso garante consistência e organização na sua base de dados, facilitando a gestão de estoque e vendas.

## Endpoints disponíveis

Essa seção descreve os endpoints disponíveis na API.

> **Nota:** Lembre-se de substituir ${BACKEND_PORT} pela porta em que seu backend está sendo executado.

### ProductType

#### GetById
- **Descrição:** Retorna um tipo de produto pelo seu ID.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/productType/{id}`

#### GetAll
- **Descrição:** Retorna todos os tipos de produtos.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/productType`

#### Store
- **Descrição:** Cria um novo tipo de produto.
- **Método:** POST
- **URL:** `http://localhost:${BACKEND_PORT}/api/productType/store`

#### Update
- **Descrição:** Atualiza um tipo de produto existente.
- **Método:** PUT
- **URL:** `http://localhost:${BACKEND_PORT}/api/productType/update/{id}`

### Product

#### GetById
- **Descrição:** Retorna um produto pelo seu ID.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/product/{id}`

#### GetAll
- **Descrição:** Retorna todos os produtos.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/product`

#### Store
- **Descrição:** Cria um novo produto.
- **Método:** POST
- **URL:** `http://localhost:${BACKEND_PORT}/api/product/store`

#### Update
- **Descrição:** Atualiza um produto existente.
- **Método:** PUT
- **URL:** `http://localhost:${BACKEND_PORT}/api/product/update/{id}`

#### Delete
- **Descrição:** Exclui um produto pelo seu ID.
- **Método:** DELETE
- **URL:** `http://localhost:${BACKEND_PORT}/api/product/delete/{id}`

#### IncreaseStock
- **Descrição:** Aumenta o estoque de um produto pelo seu ID.
- **Método:** PUT
- **URL:** `http://localhost:${BACKEND_PORT}/api/product/{id}/increase-stock/{quantity}`

#### DecreaseStock
- **Descrição:** Diminui o estoque de um produto pelo seu ID.
- **Método:** PUT
- **URL:** `http://localhost:${BACKEND_PORT}/api/product/{id}/decrease-stock/{quantity}`

#### Delete
- **Descrição:** Exclui um tipo de produto pelo seu ID.
- **Método:** DELETE
- **URL:** `http://localhost:${BACKEND_PORT}/api/productType/delete/{id}`

### Sale

#### GetById
- **Descrição:** Retorna uma venda pelo seu ID.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/sale/{id}`

#### GetAll
- **Descrição:** Retorna todas as vendas.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/sale`

#### Store
- **Descrição:** Cria uma nova venda.
- **Método:** POST
- **URL:** `http://localhost:${BACKEND_PORT}/api/sale/store`

#### Update
- **Descrição:** Atualiza uma venda existente.
- **Método:** PUT
- **URL:** `http://localhost:${BACKEND_PORT}/api/sale/update/{id}`

#### Delete
- **Descrição:** Exclui uma venda pelo seu ID.
- **Método:** DELETE
- **URL:** `http://localhost:${BACKEND_PORT}/api/sale/delete/{id}`

### InventoryMovement

#### GetById
- **Descrição:** Retorna um movimento de estoque pelo seu ID.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/inventory-movement/{id}`

#### GetAll
- **Descrição:** Retorna todos os movimentos de estoque.
- **Método:** GET
- **URL:** `http://localhost:${BACKEND_PORT}/api/inventory-movement`

#### Store
- **Descrição:** Cria um novo movimento de estoque.
- **Método:** POST
- **URL:** `http://localhost:${BACKEND_PORT}/api/inventory-movement/store`

#### Update
- **Descrição:** Atualiza um movimento de estoque existente.
- **Método:** PUT
- **URL:** `http://localhost:${BACKEND_PORT}/api/inventory-movement/update/{id}`

#### Delete
- **Descrição:** Exclui um movimento de estoque pelo seu ID.
- **Método:** DELETE
- **URL:** `http://localhost:${BACKEND_PORT}/api/inventory-movement/delete/{id}`

## Comandos Úteis

O `Makefile` incluído no projeto fornece comandos úteis para gerenciar os containers Docker. Aqui estão alguns dos principais:

- **Subir os serviços:**
  ```bash
  make up
  ```

- **Derrubar os serviços:**
  ```bash
  make down
  ```

- **Reiniciar os serviços:**
  ```bash
  make restart
  ```

- **Verificar os logs:**
  ```bash
  make logs
  ```

- **Verificar o status dos serviços:**
  ```bash
  make ps
  ```

- **Construir as imagens Docker:**
  ```bash
  make build
  ```

- **Acessar o shell do container backend:**
  ```bash
  make backend-shell
  ```

- **Executar migrações de banco de dados:**
  ```bash
  make migrate
  ```

- **Instalar dependências do Composer:**
  ```bash
  make composer
  ```

- **Acessar o shell do container do banco de dados:**
  ```bash
  make database-shell
  ```

- **Instalar dependencias e criar as tabelas do banco de dados:**
  ```bash
  make database-shell
  ```

## Estrutura dos Arquivos

- **docker-compose.yml**: Define os serviços Docker para o backend, frontend e banco de dados.
- **Dockerfile-backend**: Dockerfile para configurar o container do backend PHP.
- **Dockerfile-frontend**: Dockerfile para configurar o container do frontend com React.js.
- **Makefile**: Contém comandos para facilitar a gestão dos serviços Docker.

## Resolução de Problemas

Se encontrar problemas durante a instalação ou execução do projeto, verifique os logs dos serviços com:

```bash
make logs
```

---

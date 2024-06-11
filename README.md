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
   git clone https://github.com/seu-usuario/seu-repositorio.git
   cd seu-repositorio
   ```

2. **Crie um arquivo `.env`:**

   O projeto utiliza variáveis de ambiente para configurar os serviços. Crie um arquivo `.env` na raiz do projeto e preencha com as seguintes variáveis:

   ```bash
   # Configurações do Banco de Dados
   DB_HOST=database
   DB_PORT=5432
   DB_NAME=seu_nome_de_banco
   DB_USER=seu_usuario
   DB_PASSWORD=sua_senha

   # Configurações do Backend
   BACKEND_PORT=8000
   DB_TIMEZONE=America/Sao_Paulo

   # Configurações do Frontend
   FRONTEND_PORT=3000
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

   - **Backend**: Disponível em `http://localhost:${BACKEND_PORT}`, onde `${BACKEND_PORT}` é o valor configurado no seu `.env`.
   - **Frontend**: Disponível em `http://localhost:${FRONTEND_PORT}`, onde `${FRONTEND_PORT}` é o valor configurado no seu `.env`.
   - **Banco de Dados**: Pode ser acessado via um cliente PostgreSQL utilizando `localhost` e a porta `${DB_PORT}`.

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

## Estrutura dos Arquivos

- **docker-compose.yml**: Define os serviços Docker para o backend, frontend e banco de dados.
- **Dockerfile-backend**: Dockerfile para configurar o container do backend PHP.
- **Dockerfile-frontend**: Dockerfile para configurar o container do frontend com Node.js.
- **Makefile**: Contém comandos para facilitar a gestão dos serviços Docker.

## Resolução de Problemas

Se encontrar problemas durante a instalação ou execução do projeto, verifique os logs dos serviços com:

```bash
make logs
```

---

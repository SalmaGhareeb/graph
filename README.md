# Graph 

A web service that provides an API for clients to run algorithms and perform updates on the graphs.

## Features

- Uses Slim as the application Framework.
- Uses Mysql and Doctrine for storing and querying data.
- Uses PHP-DI
- Uses symfony/console
- Uses PHP dotenv

## Prerequisites

- Install docker as per this [installation guide ](https://docs.docker.com/compose/install/).
- Install GIT as per this [installation guide](https://git-scm.com/book/en/v2/Getting-Started-Installing-Git).
- Git clone `git clone git@github.com:SalmaAbdelhady/graph.git`

**1- Setup Using Makefile and docker**
- Run the app using  `make up`
- Hit `localhost:8080`.

**2- Or Follow steps**

- Create your `.env` file.
- RUN `composer install`
- RUN to create schema `./vendor/bin/doctrine orm:schema-tool:update  --force --complete`
- RUN to seed database  `./vendor/bin/doctrine dbal:import ./.sql/db_seed.sql`
- RUN `docker-composer up -d`
- Hit `localhost:8080`.

## Endpoints

- [Postman collection](https://documenter.getpostman.com/view/3286293/S1TbTuks?version=latest)

## Run Algorithms 
######(i.e: run `make fixtures` first')

   * Depth first search `make DFS`
     
## Done 
- [x] Graph CRUD
- [x] Nodes CRUD.
- [x] Edges CRUD
- [x] Algorithms: DepthFirstSearch
- [x] Algorithms: BreadthFirstSearch
- [x] Add Commands for each algorithm
- [x] Setup docker

## To Do
- [ ] Handle directed graphs and loops
- [ ] Create factories for create un/directed graph or edge
- [ ] Add more algorithms implementations.
- [ ] Test coverage.
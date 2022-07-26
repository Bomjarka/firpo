-- Создание структуры БД

create table users
(
    id          serial
        primary key,
    login       varchar(15)  not null,
    password    varchar(255) not null,
    first_name  varchar(15)  not null,
    second_name varchar(15)  null,
    last_name   varchar(15)  not null,
    phone       varchar(11)  not null,
    email       varchar(25)  not null,
    created_at  timestamp    not null,
    updated_at  timestamp    not null
);

create table administrators
(
    id        serial
        primary key,
    user_id   int references users (id) on delete CASCADE,
    is_active bool default false not null
);

create table pet_owners
(
    id         serial primary key,
    name       varchar   not null,
    created_at timestamp not null,
    updated_at timestamp not null
);

create table pets
(
    id            serial primary key,
    owner_id      int references pet_owners (id) on delete CASCADE,
    external_code varchar   not null,
    name          varchar   not null,
    type          varchar   not null,
    breed         varchar   not null,
    gender        varchar   not null,
    age           real       not null,
    created_at    timestamp not null,
    updated_at    timestamp not null
);

create table pet_rewards
(
    id         serial primary key,
    pet_id     int references pets (id) on delete CASCADE,
    name       varchar   not null,
    created_at timestamp not null,
    updated_at timestamp not null
);

create table pet_parents
(
    id                   serial primary key,
    pet_id               int references pets (id) on delete CASCADE,
    parent_external_code varchar   not null,

    created_at           timestamp not null,
    updated_at           timestamp not null
);

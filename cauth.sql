#Easier Debugging With auto_increment keys
drop table if exists cauth.cauth_codes;
drop table if exists cauth.cauth_log;
drop table if exists cauth.cauth_users;
drop database if exists cauth;
create database cauth;
use cauth;

create table if not exists cauth_users (
	userID int not null auto_increment,
	username varchar(25) not null,
    addr varchar(16) not null,
	primary key(userID)
);

create table if not exists cauth_codes (
    codename varchar(10) not null,
    userID int,
    
    constraint codes_fk foreign key (userID) references cauth_users(userID),
    primary key (codename)
);

create table if not exists cauth_log (
	logID int not null auto_increment,
    logTime timestamp not null default now(),
    logEvent varchar(250) not null,
    userID int,
    
    constraint logs_fk foreign key (userID) references cauth_users(userID),
    primary key (logID)
);

create table if not exists Rentals (
	rentalID int not null auto_increment,
    rentalName varchar(100) not null,
    photoURL varchar(100) not null,
    description text not null,
    primary key (rentalID)
);

insert into cauth_codes (codename) values ("newID");
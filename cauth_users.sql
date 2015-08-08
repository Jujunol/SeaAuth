create table if not exists cauth_users (
	userID varchar(10) not null,
	addr varchar(100) not null,
	primary key(userID)
);

insert into cauth_users (userID) values ("newID");
create table projects (
	id int auto_increment primary key,
	name varchar(100) not null,
	description text
);

create table tasks (
	id int auto_increment primary key,
	project int not null,
	name varchar(100) not null,
	description text not null,
	status set('ready', 'doing', 'done'),
	foreign key (project) references projects (id)
);

create table times (
	id int auto_increment primary key,
	task int not null,
	start datetime not null,
	end datetime,
	foreign key (task) references tasks (id)
);

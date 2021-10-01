CREATE TABLE IF NOT EXISTS public.authfast_permission (
	id int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	authfast_id int8 NOT NULL,
	module_id int8 NOT NULL,
	events VARCHAR(250) NOT NULL,
	CONSTRAINT pk_authfast_permission PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.permission_event (
	id int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	description VARCHAR(80) NOT NULL,
	trash bool NOT NULL DEFAULT false,
	app SMALLINT NOT NULL DEFAULT 1,
	CONSTRAINT pk_permission_evento PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.permission_module (
	id int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	"name" VARCHAR(80) NOT NULL,
	events VARCHAR(250) NULL,
	position int8 NOT NULL DEFAULT 0,
	trash bool NOT NULL DEFAULT false,
	app SMALLINT NOT NULL DEFAULT 1,
	CONSTRAINT pk_permission_module PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.permission_category_menu (
	id int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	description VARCHAR(80) NOT NULL,
	trash bool NOT NULL DEFAULT false,
	app SMALLINT NOT NULL DEFAULT 1,
	CONSTRAINT pk_permission_category_menu PRIMARY KEY (id)
);

CREATE TABLE IF NOT EXISTS public.permission_menu (
	id int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	category_id int8 NOT NULL,
	module_id int8 NOT NULL,
	description VARCHAR(80) NOT NULL,
	icon VARCHAR(80) NOT NULL,
	link VARCHAR(250) NOT NULL,
	target VARCHAR(30) NOT NULL,
	trash bool NOT NULL DEFAULT false,
	app SMALLINT NOT NULL DEFAULT 1,
	PRIMARY KEY (id)
);

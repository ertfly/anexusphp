-- public.api definition

-- Drop table

-- DROP TABLE public.api;

CREATE TABLE IF NOT EXISTS public.api (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	authfast_id int8 not null,
	"name" varchar(250) NOT NULL,
	img_logo varchar(250) NULL,
	terms_privacy text NULL,
	terms_use text NULL,
	created_at timestamp(0) NOT NULL,
	updated_at timestamp(0) NULL,
	expired_at timestamp(0) NULL,
	CONSTRAINT api_pk PRIMARY KEY (id)
);


-- public.api_key definition

-- Drop table

-- DROP TABLE public.api_key;

CREATE TABLE public.api_key (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
    api_id int4 NOT NULL,
    "name" varchar(100) NOT null,
    app_key varchar(32) NOT NULL,
	secret_key varchar(64) NOT NULL,
	production bool NULL DEFAULT false,
	uri_domain varchar(80) NOT NULL,
	uri_hook varchar(250) NOT NULL,
	created_at timestamp(0) NOT NULL,
	updated_at timestamp(0) NULL,
	expired_at timestamp(0) NULL,
	CONSTRAINT api_key_pk PRIMARY KEY (id)
);


-- public.app definition

-- Drop table

-- DROP TABLE public.app;

CREATE TABLE IF NOT EXISTS public.app (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	"name" varchar(80) NOT NULL,
	CONSTRAINT pk_app PRIMARY KEY (id)
);


-- public.app_authfast definition

-- Drop table

-- DROP TABLE public.app_authfast;

CREATE TABLE public.app_authfast (
    id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	app_id int4 NOT NULL,
	authfast_id int8 NOT NULL,
	CONSTRAINT app_authfast_pk PRIMARY KEY (app_id, authfast_id)
);


-- public.app_session definition

-- Drop table

-- DROP TABLE public.app_session;

CREATE TABLE IF NOT EXISTS public.app_session (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	"token" varchar(64) NOT NULL,
	app_id int4 NOT NULL,
	authfast_id int8 NULL,
	support_code varchar(6) null,
	"type" varchar(1) NOT NULL,
	access_ip varchar(20) NULL,
	access_browser varchar(150) NULL,
	created_at timestamp NOT NULL,
	updated_at timestamp NOT NULL,
	CONSTRAINT app_session_pkey PRIMARY KEY (token)
);


-- public.authfast definition

-- Drop table

-- DROP TABLE public.authfast;

CREATE TABLE IF NOT EXISTS public.authfast (
	id int8 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	code varchar(100) NOT NULL,
	firstname varchar(80) NULL,
	lastname varchar(80) NULL,
	username varchar(15) NOT NULL,
	email varchar(100),
	photo varchar(250),
	banner varchar(250),
	created_at timestamp NOT NULL,
	updated_at timestamp NULL,
	expired_at timestamp NULL,
	CONSTRAINT pk_authfast PRIMARY KEY (id)
);


-- public."configuration" definition

-- Drop table

-- DROP TABLE public."configuration";

CREATE TABLE IF NOT EXISTS public."configuration" (
	id varchar(80) NOT NULL,
	value text NOT NULL,
	description varchar NULL,
	CONSTRAINT configuration_un UNIQUE (id)
);


-- public."language" definition

-- Drop table

-- DROP TABLE public."language";

CREATE TABLE IF NOT EXISTS public."language" (
	id varchar(250) NOT NULL,
	region_country_id int4 NOT NULL,
	value varchar(250) NOT NULL,
	screen_id int4 NOT NULL
);


-- public.language_screen definition

-- Drop table

-- DROP TABLE public.language_screen;

CREATE TABLE IF NOT EXISTS public.language_screen (
	id int4 NOT NULL,
	description text NOT NULL,
	CONSTRAINT language_screen_pk PRIMARY KEY (id)
);


-- public.region_city definition

-- Drop table

-- DROP TABLE public.region_city;

CREATE TABLE IF NOT EXISTS public.region_city (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	state_id int4 NOT NULL,
	"name" varchar(250) NOT NULL,
	code varchar(15) NULL,
	CONSTRAINT pk_region_city PRIMARY KEY (id)
);


-- public.region_country definition

-- Drop table

-- DROP TABLE public.region_country;

CREATE TABLE IF NOT EXISTS public.region_country (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	"name" varchar(100) NOT NULL,
	code varchar(3) NOT NULL,
	initials varchar(3) NOT NULL,
	flag varchar(100) NULL,
	principal bool NOT NULL DEFAULT false,
	visible bool NOT NULL DEFAULT true,
	date_format varchar(50) NULL,
	date_hour_format varchar(50) NULL,
	locale varchar(50) NULL,
	timezone varchar(50) NULL,
	CONSTRAINT region_country_pkey PRIMARY KEY (id)
);


-- public.region_state definition

-- Drop table

-- DROP TABLE public.region_state;

CREATE TABLE IF NOT EXISTS public.region_state (
	id int4 NOT NULL GENERATED BY DEFAULT AS IDENTITY,
	country_id int2 NOT NULL,
	"name" varchar(100) NOT NULL,
	initials varchar(15) NULL,
	CONSTRAINT pk_region_state PRIMARY KEY (id)
);
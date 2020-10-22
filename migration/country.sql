DO $$
    BEGIN
        IF NOT EXISTS (SELECT id FROM region_country WHERE id = 1) THEN
            INSERT INTO public.region_country (id,"name",code,initials,flag,principal,visible,date_format,date_hour_format,locale,timezone) VALUES
            (1,'Brasil','055','BRA','brasil.png',true,true,'dd/MM/YYYY','dd/MM/YYYY HH:MM:ss','pt_BR','America/Sao_Paulo');
        END IF;
END $$;
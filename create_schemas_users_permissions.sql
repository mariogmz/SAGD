CREATE SCHEMA `sagd_local` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_local'@'localhost' IDENTIFIED BY 'zegucomlocal';
GRANT ALL ON sagd_local.* TO 'sagd_local'@'localhost';

CREATE SCHEMA `sagd_test` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_test'@'localhost' IDENTIFIED BY 'zegucomtest';
GRANT ALL ON sagd_test.* TO 'sagd_test'@'localhost';

CREATE SCHEMA `sagd_prod` DEFAULT CHARACTER SET utf8 COLLATE utf8_spanish_ci;
CREATE USER 'sagd_prod'@'localhost' IDENTIFIED BY 'zegucomprod';
GRANT ALL ON sagd_prod.* TO 'sagd_prod'@'localhost';


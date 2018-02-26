use UserData
create table if not exists UserLogInfo (filename VARCHAR(120), useragent VARCHAR(120));
load data local infile '/var/log/apache2/testdbinfo.txt' into table UserLogInfo;

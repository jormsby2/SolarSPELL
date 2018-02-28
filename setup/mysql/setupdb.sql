use UserData
create table if not exists UserLogInfo (content_path VARCHAR(120), user_agent VARCHAR(120), main_category VARCHAR(120), file_name VARCHAR(120));
load data local infile '/var/log/apache2/testdbinfo.txt' into table UserLogInfo;

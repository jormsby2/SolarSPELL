#!/usr/bin/python
import MySQLdb

source_path = "/var/log/apache2/access1.log.bak"
dest_path = "/var/log/apache2/access2.log"

#consider using sort -u command instead of this script
def remove_duplicate_lines(source_path):
	uniq = set()
	with open(source_path, "r") as fin:
		for line in fin:
			uniq.add(line)
	with open(dest_path, "w") as fout:
		for line in uniq:
			fout.write(line)
	# upload log to database
    upload_log(dest_path)

def upload_log(dest_path):
    db = MySQLdb.connect(host="localhost",
            user="root",
            passwd="raspberry",
            db="UserData")

    cur = db.cursor()

    with open(dest_path, "r") fin:
        for line in fin:
            tokens = line.split(" ") 
            if tokens[1] == "GET":
                tokens = line[2].split('"')
                content_path = token[0]
                user_agent = token[1]

                tokens = content_path.split('/')
                main_category = tokens[3]
                file_name = tokens[len(tokens)-1]
                
                cur.execute("""INSERT INTO UserData.UserDataInfo VALUES 
                (%s,%s,%s,%s)""", (content_path,user_agent,main_category,file_name)
                cur.commit()

remove_duplicate_lines(source_path) 			

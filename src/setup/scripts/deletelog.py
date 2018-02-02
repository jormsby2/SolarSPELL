import os
import shutil

source_path = "/var/log/apache2/access1.log"

def backup_and_clear(source_path):
	dest_path = source_path + ".bak"

	shutil.copy2(source_path, dest_path)
	
	#cannot remove file or apache logger will lose pointer to it
	#os.remove(source_path)
	with open(source_path, "w") as fsrc:
		print("file overwritten")

	return dest_path

backup_and_clear(source_path)

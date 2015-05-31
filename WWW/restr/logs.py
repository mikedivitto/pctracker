#!/usr/bin/python

import memcache
import MySQLdb

db = MySQLdb.connect(host="library.newpaltz.edu", user="pctracker", passwd="SncQTWQX5MUT4E95", db="pctracker")
mc = memcache.Client(['127.0.0.1:11211'], debug=0)

cur = db.cursor()
cur.execute("SELECT * FROM ol_computers")

for row in cur.fetchall():
	print row



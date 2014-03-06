from socket import *
import threading
import thread
import urllib
import urllib2
url = "http://cs.newpaltz.edu/~n02482434/openlabs/func/update.php"
def handler(clientsock,addr):
	data = clientsock.recv(BUFSIZ)
	if not data:
		return
	info = data.split(";")
	#clientsock.send(msg)
	values = {'hname' : info[0],
		  'uname' : info[1],
		  'tstamp' : info[2] }
	data = urllib.urlencode(values)
	furl = url + '?' + data
	#print furl
	try:
		test = urllib2.urlopen(furl)
	except urllib2.HTTPError, err:
		return
	except urllib2.URLError, err:
		return
	#print test
	#print 'done?'
	clientsock.close()
	
if __name__=='__main__':
	HOST = 'localhost'
	PORT = 5562
	BUFSIZ = 1024
	ADDR = (HOST, PORT)
	serversock = socket(AF_INET, SOCK_STREAM)
	serversock.bind(ADDR)
	serversock.listen(2)

	while 1:
		print 'waiting for connection...'
		clientsock, addr = serversock.accept()
		print '...connected from:', addr
		thread.start_new_thread(handler, (clientsock, addr))

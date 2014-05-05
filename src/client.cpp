#include<stdio.h>
#include<winsock2.h>
#include<time.h>
#include <Windows.h>
#pragma comment(lib,"ws2_32.lib") //Winsock Library
int main(int argc, char *argv[])
{
	while (true){
		if (argc != 4){
			printf("Usage: client.exe [Host IP Addr.] [Host domain] [Directory on domain]\n");
			break;
		}
		while (true){
			WSADATA wsa;
			SOCKET s;
			struct sockaddr_in server;
			char message[500], server_reply[2000], hname[100], *get, *host, *conn, tmp[100];
			int recv_size, timevar;
			DWORD nHostName = sizeof(hname);
			//get = "GET /~n02482434/openlabs/";
			//host = "Host: cs.newpaltz.edu\r\n";
			conn = "Connection: close\r\n\r\n";
			GetComputerName(hname, &nHostName);
			timevar = time(NULL);
			sprintf_s(tmp, "%d", timevar);
			sprintf_s(message, "GET %sfunc/update.php?hname=%s&tstamp=%s HTTP/1.1\r\nHost: %s\r\n%s", argv[3], hname, tmp, argv[2], conn);
			if (WSAStartup(MAKEWORD(2, 2), &wsa) != 0){ break; }
			if ((s = socket(AF_INET, SOCK_STREAM, 0)) == INVALID_SOCKET){ break; }
			server.sin_addr.s_addr = inet_addr(argv[1]);
			server.sin_family = AF_INET;
			server.sin_port = htons(80);
			if (connect(s, (struct sockaddr *)&server, sizeof(server)) < 0){ break; }
			if (send(s, message, strlen(message), 0) < 0){ break; }
			if ((recv_size = recv(s, server_reply, 2000, 0)) == SOCKET_ERROR){ break; }
			server_reply[recv_size] = '\0';
			printf(server_reply);
			closesocket(s);
			break;
		}
		Sleep(60000);
	}
	return 0;
}
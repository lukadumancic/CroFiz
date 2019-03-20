import mysql.connector
from time import *
import datetime

sati=0
minute=0

while True:
    if ctime().split()[3].split(":")[1]!=minute:
        sati=ctime().split()[3].split(":")[0]
        minute=ctime().split()[3].split(":")[1]
        print(sati,":",minute)
    if ctime().split()[3].split(":")[0]=="12" and ctime().split()[3].split(":")[1]=="00":
        conn=mysql.connector.connect(user='crofiz', password='peta@crofiz',
                                          host="crofiz.ddns.net",
                                          database='newdatabase',
                                         raise_on_warnings=True,)
                
        cursor = conn.cursor(buffered=True)
        for i in range(1,5):
            f=open(str(i)+".razred.txt")
            l=f.readlines()
            ime=l[0][4:len(l[0])-1]
            tekst=l[1][6:len(l[1])-1]
            rjesenje=l[2][9:len(l[2])-1]
            jedinica=l[3][9:len(l[3])-1]
            podrucje=l[4][9:len(l[4])-1]
            br=l[5][3:len(l[5])-1]
            slika=l[6][6:len(l[6])-1]
            dan=l[7][4:]
            print(ime,tekst,rjesenje,jedinica,podrucje,br,slika,dan)
            cursor.execute("INSERT INTO `newdatabase`.`zadaci` (`ime`, `tekst`, `rjesenje`, `jedinica`, `razred`, `podrucje`, `br`, `slika`, `dan`) VALUES ('{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}')".format(ime,tekst,rjesenje,jedinica,str(i),podrucje,br,slika,dan))
        cursor.execute("INSERT INTO `newdatabase`.`objave` (`objava`, `idkorisnik`,`br`) VALUES ('Dnevni zadaci su spremni! Možes li riješiti današnji problem?', '35', '0')")
        if datetime.datetime.today().weekday()==6:
            print("Tjedni zadaci")
            for i in range(1,5):
                f=open(str(i)+".razredTjedni.txt","r")
                l=f.readlines()
                ime=l[0][4:len(l[0])-1]
                tekst=l[1][6:len(l[1])-1]
                rjesenje=l[2][9:len(l[2])-1]
                jedinica=l[3][9:len(l[3])-1]
                podrucje=l[4][9:len(l[4])-1]
                br=l[5][3:len(l[5])-1]
                slika=l[6][6:len(l[6])-1]
                dan=l[7][4:]
                print(ime,tekst,rjesenje,jedinica,podrucje,br,slika,dan)
                cursor.execute("INSERT INTO zadaci (`ime`, `tekst`, `rjesenje`, `jedinica`, `razred`, `podrucje`, `br`, `slika`, `dan`) VALUES ('{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}', '{}')".format(ime,tekst,rjesenje,jedinica,str(i),podrucje,br,slika,dan))

        cursor.close()
        conn.commit()
        conn.close()
        sleep(100)
    sleep(5)
    

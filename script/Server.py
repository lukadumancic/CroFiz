import mysql.connector
from time import *
import smtplib
import hashlib
import os
import base64
from random import randint
import datetime


def randomPass():
    pas=""
    for i in range(8):
        pas+=chr(randint(65,90))
        pas+=chr(randint(97,122))
    return pas


mail = smtplib.SMTP("smtp.gmail.com", 587)
mail.ehlo()
mail.starttls()

mail.login("crofiz.webteam@gmail.com", "crofiz124578*")

while True:
    try:
        conn=mysql.connector.connect(user='root', password='124578',
                                  host="35.238.67.22",
                                  database='crofiz',
                                 raise_on_warnings=True,)
        break
    except:
        print("Error connecting database")

print("Server started")
brError=0
brZadaci=0

sati=0
minute=0
while True:
    print("Server call")
    try:
        if ctime().split()[3].split(":")[1]!=minute:
            sati=ctime().split()[3].split(":")[0]
            minute=ctime().split()[3].split(":")[1]
            print sati,":",minute
        ##if(brZadaci>0):
          ##  brZadaci-=1
        #Dnevni zadaci i tjedni
        '''if brZadaci==0 and ctime().split()[3].split(":")[0]=="12" and ctime().split()[3].split(":")[1]=="00":
            brZadaci=10000
            cursor = conn.cursor(buffered=True)
            print("Dnevni zadaci")
            for i in range(1,5):
                f=open("Dnevni/"+str(i)+".razred.txt","r")
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
            cursor.execute("INSERT INTO `crofiz`.`objave` (`objava`, `idkorisnik`,`br`) VALUES ('Dnevni zadaci su spremni! Mozes li rijesiti danasnji problem?', '35', '0')")
                
            if datetime.datetime.today().weekday()==5:
                print("Tjedni zadaci")
                for i in range(1,5):
                    f=open("Tjedni/"+str(i)+".razred.txt","r")
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
                
                
            cursor.close()'''
            


        
        #Server restart svakog sata
        if(ctime().split()[3].split(":")[0]=="23" and ctime().split()[3].split(":")[1]=="59"):
            print("Pozivanje restarta servera")
            cursor1 = conn.cursor(buffered=True)
            cursor1.execute("INSERT INTO `tasks` (`br`) VALUES ('1')")
            cursor1.close()
            sleep(60)
        
        cursor = conn.cursor(buffered=True)
        cursor2 = conn.cursor(buffered=True)
        
        cursor.execute("SELECT id, kod, email FROM `privremeniKorisnici` WHERE br=0")
        

        for (id,kod,email) in cursor:
            print(id,kod,email)
            message = """From: Cro Fiz <{}>
To: <{}>
MIME-Version: 1.0
Content-type: text/html
Subject: CroFiz Aktivacija racuna


Kako biste aktivirali svoj racun kliknite na sljedecu stranicu:<br>
<ul>http://34.121.205.40/AktivacijaKoda.php?kod={}</ul>

""".format("crofiz.webteam@gmail.com",email,kod)
            
            mail.sendmail("crofiz.webteam@gmail.com",email,message)    
            cursor2.execute("UPDATE `privremeniKorisnici` SET br=1 WHERE id={}".format(str(id)))
            
            

        cursor.close()
        cursor2.close()

        cursor3 = conn.cursor(buffered=True)
        cursor4 = conn.cursor(buffered=True)
        cursor5 = conn.cursor(buffered=True)
        
        cursor3.execute("SELECT zab FROM zaboravljeno")
        
        for (zab) in cursor3:
            zab=str(zab)[3:len(zab)-4]
            print("Zaboravljena")
            print("SELECT email, nick, pass FROM korisnici WHERE email=\'{}\'".format(zab,zab))
            cursor4.execute("SELECT email, nick, pass,id FROM korisnici WHERE email=\'{}\' ".format(zab,zab))

            ar=cursor4.fetchall()
            
            if len(ar)==0:
                cursor5.execute("DELETE FROM zaboravljeno WHERE zab=\'{}\'".format(zab))

            else:  
                for i in ar:
                    email=i[0]
                    user=i[1]
                    pas=randomPass()
                    id=i[3]
                    message = """From: Cro Fiz <{}>
To: You <{}>
MIME-Version: 1.0
Content-type: text/html
Subject: CroFiz Podaci za prijavu

Podaci za prijavu su:<br>
<ul>username:{}</ul>
<ul>password:{}</ul>

""".format("crofiz.webteam@gmail.com",email,user,pas)
                
                    mail.sendmail("crofiz.webteam@gmail.com",email,message)
                    cursor5.execute("DELETE FROM zaboravljeno WHERE zab=\'{}\'".format(zab))
                    
                    pas=hashlib.md5(pas).hexdigest()
                    cursor5.execute("UPDATE `korisnici` SET `pass`='{}' WHERE `id`='{}'".format(str(pas),str(id)))
                    
                    
        
        
        cursor3.close()
        cursor4.close()
        cursor5.close()


        #Slike
        
        """cursor6 = conn.cursor(buffered=True)
        cursor7 = conn.cursor(buffered=True)
        cursor6.execute("select id,name,content from skripte where br=0 and `type` like \'image%\'")
        for (id,name,content) in cursor6:
            print("Slike ",id)
            file=open("Slike\\"+name+str(id)+".jpg","wb")
            try:
                file.write(content.decode('base64'))
            except:
                file.write(content[0].decode('base64'))
            file.close()
            cursor7.execute("UPDATE skripte SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor6.close()
        cursor7.close()"""

        
        #Tekst
        """cursor66 = conn.cursor(buffered=True)
        cursor77 = conn.cursor(buffered=True)
        cursor66.execute("select id,name,content from skripte where br=0 and `type` not like \'image%\' and `type` not like \'%pdf\' and `type` not like \'%kset\'")
        for (id,name,content) in cursor66:
            print("Tekst ",id)
            file=open("Dokumenti\\"+name+str(id)+".docx","wb")
            try:
                file.write(content)
            except:
                file.write(content[0])
            file.close()
            cursor77.execute("UPDATE skripte SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor66.close()
        cursor77.close()"""

        #Pdf
        """cursor66 = conn.cursor(buffered=True)
        cursor77 = conn.cursor(buffered=True)
        cursor66.execute("select id,name,content from skripte where br=0 and `type` like \'%pdf\'")
        for (id,name,content) in cursor66:
            print("Pdf ",id)
            file=open("Dokumenti\\"+name+str(id)+".pdf","wb")
            try:
                file.write(content)
            except:
                file.write(content[0])
            file.close()
            cursor77.execute("UPDATE skripte SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor66.close()
        cursor77.close()"""

        #xls
        """cursor66 = conn.cursor(buffered=True)
        cursor77 = conn.cursor(buffered=True)
        cursor66.execute("select id,name,content from skripte where br=0 and `type` like \'%kset\'")
        for (id,name,content) in cursor66:
            print("XLS ",id)
            file=open("Dokumenti\\"+name+str(id)+".xls","wb")
            try:
                file.write(content)
            except:
                file.write(content[0])
            file.close()
            cursor77.execute("UPDATE skripte SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor66.close()
        cursor77.close()"""

        #Nova slika wow
        cursor8 = conn.cursor(buffered=True)
        cursor9 = conn.cursor(buffered=True)
        cursor8.execute("select id,slika from korisnici where `br`='0'")
        for (id,slika) in cursor8:
            print("Slika kor", id)
            file=open("Slike\\Korisnik"+str(id)+".jpg","wb")
            try:
                file.write(slika.decode('base64'))
            except:
                file.write(slika[0].decode('base64'))
            file.close()
            cursor9.execute("UPDATE korisnici SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor8.close()
        cursor9.close()

        #Nova grupa
        """cursor8 = conn.cursor(buffered=True)
        cursor9 = conn.cursor(buffered=True)
        cursor8.execute("SELECT id FROM `grupe` where slika is null and (br='0' or br is null)")
        for (id) in cursor8:
            print("Bezslikna Grupa ",id)
            id=str(id).replace("(","").replace(")","").replace(",","")
            with open("Slike\\grupa.png", "rb") as f:
                es = base64.b64encode(f.read())
            file=open("Slike\\Grupa"+id+".jpg","wb")
            file.write(es.decode('base64'))
            file.close()
            f.close()

            print("UPDATE `grupe` SET `br`='1' WHERE `id`='"+id+"'")
            cursor9.execute("UPDATE `grupe` SET `br`='1' WHERE `id`='"+id+"'")

        cursor8.close()
        cursor9.close()"""

        #Nova slika grupa
        """cursor8 = conn.cursor(buffered=True)
        cursor9 = conn.cursor(buffered=True)
        cursor8.execute("select id,slika from grupe where `br`='0'")
        for (id,slika) in cursor8:
            print("Slika grupa", id)
            file=open("Slike\\Grupa"+str(id)+".jpg","wb")
            try:
                file.write(slika.decode('base64'))
            except:
                file.write(slika[0].decode('base64'))
            file.close()
            cursor9.execute("UPDATE grupe SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor8.close()
        cursor9.close()"""

        #Korisnici bez slike
        cursor8 = conn.cursor(buffered=True)
        cursor9 = conn.cursor(buffered=True)
        cursor8.execute("select id,slika from korisnici where slika is null and (br='0' or br is null)")
        for (id,slika) in cursor8:
            print("Bezslikni ",id)
            with open("Slike\\acc.jpg", "rb") as f:
                es = base64.b64encode(f.read())
            file=open("Slike\\Korisnik"+str(id)+".jpg","wb")
            file.write(es.decode('base64'))
            file.close()
            f.close()
            
            cursor9.execute("UPDATE korisnici SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor8.close()
        cursor9.close()

        #Slike objava
        """cursor6 = conn.cursor(buffered=True)
        cursor7 = conn.cursor(buffered=True)
        cursor6.execute("select id,data from objave where br=0 and `type` like \'image%\'")
        for (id,data) in cursor6:
            print("Slika objave ", id)
            file=open("Slike\\objava"+str(id)+".jpg","wb")
            try:
                file.write(data.decode('base64'))
            except:
                file.write(data[0].decode('base64'))
            file.close()
            cursor7.execute("UPDATE objave SET `br`='1' WHERE `id`='"+str(id)+"'")

        cursor6.close()
        cursor7.close()"""
            

        #Slike objava
        """cursor6 = conn.cursor(buffered=True)
        cursor7 = conn.cursor(buffered=True)
        "select id,data from objavegrupa where br=0 and `type` like \'image%\'"
        cursor6.execute("select id,data from objavegrupa where br=0 and `type` like \'image%\'")
        for (id,data) in cursor6:
            print("Slika objave ", id)
            file=open("Slike\\objavagrupa"+str(id)+".jpg","wb")
            try:
                file.write(data.decode('base64'))
            except:
                file.write(data[0].decode('base64'))
            file.close()
            print (cursor7.execute("UPDATE objavegrupa SET `br`='1' WHERE `id`='"+str(id)+"'"))

        cursor6.close()
        cursor7.close()"""

        #Restart servera
        """cursor6 = conn.cursor(buffered=True)
        cursor7 = conn.cursor(buffered=True)
        cursor6.execute("select * from tasks")
        for (id,br) in cursor6:
            print(br)
            #Restart
            if br==1:
                print("Restart")
                os.system('net stop Apache2.4')
                os.system('net start Apache2.4')
            #Stop
            if br==2:
                print("Stop")
                os.system('net stop Apache2.4')
            #Start
            if br==3:
                print("Start")
                os.system('net start Apache2.4')
            print(cursor7.execute("DELETE FROM `tasks` WHERE `id`='"+str(id)+"'"))

        cursor6.close()
        cursor7.close()"""

        #Slike izazova
        """cursor6 = conn.cursor(buffered=True)
        cursor7 = conn.cursor(buffered=True)
        cursor6.execute("select id,idzadatak,data from slike where `type` like \'image%\'")
        for (id,idzadatak,content) in cursor6:
            print("Slike izazova",idzadatak)
            file=open("Slike\\Izazov"+str(idzadatak)+".jpg","wb")
            try:
                file.write(content.decode('base64'))
            except:
                file.write(content[0].decode('base64'))
            file.close()
            cursor7.execute("DELETE FROM `slike` WHERE `id`='"+str(id)+"'")

        cursor6.close()
        cursor7.close()"""


        conn.commit()
        

       
    except Exception, e:
        print(e)
        print("error")
        brError+=1

        conn.close()
        conn=mysql.connector.connect(user='root', password='124578',
                                  host="35.238.67.22",
                                  database='crofiz',
                                 raise_on_warnings=True,)
        
        mail.close()
        mail = smtplib.SMTP("smtp.gmail.com", 587)
        mail.ehlo()
        mail.starttls()

        mail.login("crofiz.webteam@gmail.com", "crofiz124578*")
        
        if brError==10:
            mail.sendmail("crofiz.webteam@gmail.com","crofiz.webteam@gmail.com","Pad servera")

mail.close()

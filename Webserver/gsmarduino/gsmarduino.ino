/*Note: this code is a demo for how to using gprs shield to send sms message, dial a voice call and 
send a http request to the website, upload data to pachube.com by TCP connection,

The microcontrollers Digital Pin 7 and hence allow unhindered
communication with GPRS Shield using SoftSerial Library. 
IDE: Arduino 1.0 or later
Replace the following items in the code:
1.Phone number, don't forget add the country code
2.Replace the Access Point Name
3. Replace the Pachube API Key with your personal ones assigned
to your account at cosm.com
 * Modified by keen 
 * Date: 18/03/2017
 * Note: Only fix bug
*/
#include <SoftwareSerial.h>
#include <String.h>

SoftwareSerial mySerial(8, 7);

void setup()
{
mySerial.begin(9600);               // the GPRS baud rate   
Serial.begin(9600);    // the GPRS baud rate 
delay(500);
}

void loop()
{
//after start up the program, you can using terminal to connect the serial of gprs shield,
//if you input 'q' in the terminal, the program will execute  GetSignalQuality(),it will show the signal quality,
//if you input 't' in the terminal, the program will execute SendTextMessage(), it will show how to send a sms message,
//if input 'd' in the terminal, it will execute DialVoiceCall(), etc.

if (Serial.available())
switch(Serial.read()){

case 'q':
GetSignalQuality();
break;
case 't':
SendTextMessage();
break;
case 'd':
DialVoiceCall();
break;
case 'h':
SubmitHttpRequest();
break;
case 's':
Send2Pachube();
break;
}
if (mySerial.available())
Serial.write(mySerial.read());
}
///GetSignalQuality()
///get the signal quality of GSM model.
void GetSignalQuality(){
     String response = ""; 
     long int time = millis();   
     Serial.println("Getting the sinal quality...");
     Serial.println("Tips:+CSQ: XX,QQ : It means the Signal Quality poorly when the XX is '99'!");
     mySerial.println("AT+CSQ");    
     while( (time+2000) > millis()){
        while(mySerial.available()){       
          response += char(mySerial.read());
        }  
      }    
      Serial.print(response);    
}

///SendTextMessage()
///this function is to send a sms message
void SendTextMessage()
{
mySerial.print("\r");
delay(1000);                    //Wait for a second while the modem sends an "OK"
mySerial.print("AT+CMGF=1\r");    //Because we want to send the SMS in text mode
delay(1000);
mySerial.print("AT+CMGS=\"+639362192670\"\r");    //Start accepting the text for the message
//to be sent to the number specified.
//Replace this number with the target mobile number.
delay(1000);
mySerial.print("Hello,Elecrow!\r");   //The text for the message
delay(1000);
mySerial.write(0x1A);  //Equivalent to sending Ctrl+Z 
}

///DialVoiceCall
///this function is to dial a voice call
void DialVoiceCall()
{
mySerial.println("ATD + +639362192670;");//dial the number
delay(100);
mySerial.println();
}

///SubmitHttpRequest()
///this function is submit a http request
///attention:the time of delay is very important, it must be set enough 
void SubmitHttpRequest()
{
mySerial.println("AT+CSQ");
delay(100);

ShowSerialData();// this code is to show the data from gprs shield, in order to easily see the process of how the gprs shield submit a http request, and the following is for this purpose too.

mySerial.println("AT+CGATT?");
delay(100);

ShowSerialData();

mySerial.println("AT+SAPBR=3,1,\"CONTYPE\",\"GPRS\"");//setting the SAPBR, the connection type is using gprs
delay(1000);

ShowSerialData();

mySerial.println("AT+SAPBR=3,1,\"APN\",\"CMNET\"");//setting the APN, the second need you fill in your local apn server
delay(4000);

ShowSerialData();

mySerial.println("AT+SAPBR=1,1");//setting the SAPBR, for detail you can refer to the AT command mamual
delay(5000);

ShowSerialData();

mySerial.println("AT+HTTPINIT"); //init the HTTP request

delay(3000); 
ShowSerialData();

mySerial.println("AT+HTTPPARA=\"URL\",\"www.google.com\"");// setting the httppara, the second parameter is the website you want to access
delay(3000);

ShowSerialData();

mySerial.println("AT+HTTPACTION=0");//submit the request 
delay(10000);//the delay is very important, the delay time is base on the return from the website, if the return datas are very large, the time required longer.
//while(!mySerial.available());

ShowSerialData();

mySerial.println("AT+HTTPREAD");// read the data from the website you access
delay(300);

ShowSerialData();

mySerial.println("");
delay(100);
}

///send2Pachube()///
///this function is to send the sensor data to the pachube, you can see the new value in the pachube after execute this function///
void Send2Pachube()
{
mySerial.println("AT+CGATT?");
delay(100);

ShowSerialData();

mySerial.println("AT+CSTT=\"CMNET\"");//start task and setting the APN,
delay(1000);

ShowSerialData();

mySerial.println("AT+CIICR");//bring up wireless connection
delay(300);

ShowSerialData();

mySerial.println("AT+CIFSR");//get local IP adress
delay(2000);

ShowSerialData();

mySerial.println("AT+CIPSPRT=0");
delay(3000);

ShowSerialData();

mySerial.println("AT+CIPSTART=\"tcp\",\"api.cosm.com\",\"8081\"");//start up the connection
delay(2000);

ShowSerialData();

mySerial.println("AT+CIPSEND");//begin send data to remote server
delay(8000);
ShowSerialData();
String humidity = "1031";//these 4 line code are imitate the real sensor data, because the demo did't add other sensor, so using 4 string variable to replace.
String moisture = "1242";//you can replace these four variable to the real sensor data in your project
String temperature = "30";//
String barometer = "60.56";//
mySerial.print("\"method\": \"put\",\"resource\": \"/feeds/43634/\",\"params\"");//here is the feed you apply from pachube
delay(500);
ShowSerialData();
mySerial.print(": ,\"headers\": \"X-PachubeApiKey\":");//in here, you should replace your pachubeapikey
delay(500);
ShowSerialData();
mySerial.print(" \"_cXwr5LE8qW4a296O-cDwOUvfddFer5pGmaRigPsiO0");//pachubeapikey
delay(500);
ShowSerialData();
mySerial.print("jEB9OjK-W6vej56j9ItaSlIac-hgbQjxExuveD95yc8BttXc");//pachubeapikey
delay(500);
ShowSerialData();
mySerial.print("Z7_seZqLVjeCOmNbEXUva45t6FL8AxOcuNSsQS\",\"body\":");
delay(500);
ShowSerialData();
mySerial.print(" \"version\": \"1.0.0\",\"datastreams\": ");
delay(500);
ShowSerialData();
mySerial.println("[\"id\": \"01\",\"current_value\": \"" + barometer + "\",");
delay(500);
ShowSerialData();
mySerial.println("\"id\": \"02\",\"current_value\": \"" + humidity + "\",");
delay(500);
ShowSerialData();
mySerial.println("\"id\": \"03\",\"current_value\": \"" + moisture + "\",");
delay(500);
ShowSerialData();
mySerial.println("\"id\": \"04\",\"current_value\": \"" + temperature + "\"],\"token\": \"lee\"");


delay(500);
ShowSerialData();

mySerial.println((char)26);//sending
delay(5000);//waitting for reply, important! the time is base on the condition of internet 
mySerial.println();

ShowSerialData();

mySerial.println("AT+CIPCLOSE");//close the connection
delay(100);
ShowSerialData();

}
void ShowSerialData()
{
while(mySerial.available()!=0)
Serial.write(mySerial.read());
}

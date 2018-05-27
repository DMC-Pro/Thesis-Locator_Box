#include <Adafruit_FONA.h>
#include <RH_ASK.h>
#include <SPI.h> 

RH_ASK driver;


#define FONA_RX 2
#define FONA_TX 3
#define FONA_RST 4
//#define KEY 9
#define buttonPin 7


#include <SoftwareSerial.h>
SoftwareSerial fonaSS = SoftwareSerial(FONA_TX, FONA_RX);
SoftwareSerial *fonaSerial = &fonaSS;
Adafruit_FONA fona = Adafruit_FONA(FONA_RST);
int i;
float origlat, origlong;
int buttonState = 0;

void setup() {
  // put your setup code here, to run once:
  Serial.begin(115200);
  while (!Serial) {
    ; 
  } 
  Serial.println("Help Box");

  pinMode(buttonPin,INPUT_PULLUP);
  //pinMode(KEY,OUTPUT);

  if (!driver.init())
         Serial.println("init failed");
         
  fonaSerial->begin(4800);
  if (! fona.begin(*fonaSerial)) {
    Serial.println(F("Couldn't find FONA"));
  }
  Serial.println(F("FONA is OK"));
  Serial.print(F("Found "));
  
  delay(100); 
}

void loop() {
  // put your main code here, to run repeatedly:
  buttonState = digitalRead(buttonPin);
  //digitalWrite(KEY,HIGH);
  //while(! fona.begin(*fonaSerial)){
    //Serial.println("Waiting for FONA");
   // }
    if (buttonState == HIGH){
        Serial.println("Waiting");
    }else{
      String location = gps();
      String messages = location;
      char txt[messages.length() - 1];
      messages.toCharArray(txt, messages.length());
        
      for (i=0; i<5; i++){
      Serial.println(txt);
      //flushSerial();
      Serial.println("Help Box");
      //const char *msg = "+01+14.5991523+121.015376+";
      driver.send((uint8_t *)txt, strlen(txt));
      driver.waitPacketSent();
      Serial.println(txt);
      delay(5000);
      }
      
    }
}  
  
//void flushSerial() {
  //while (Serial.available())
  //  Serial.read();
//}
String gps() {

  String lat, lon;
  Serial.println(F("Enabling GPS..."));
  origlat = 20.98006;
  origlong = 127.23511;
  
  float latitude, longitude;
  int textconfirm;
  int8_t stat;

  //checks GPS fix status
  stat = fona.GPSstatus();
  if (stat<2){
    Serial.println(F("Failed to query"));
    lat = String(origlat, 6);
    lon = String(origlong, 6);
    return String("+") + "10" + String("+") + lat + String("+") + lon;
  }else {
    lat = String(latitude, 6);
    lon = String(longitude, 6);
    return String("+") + "10" + String("+") + lat + String("+") + lon;
  }
}


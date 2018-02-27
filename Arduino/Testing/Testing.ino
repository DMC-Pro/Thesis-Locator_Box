#include <Adafruit_FONA.h>

#define FONA_RX 2
#define FONA_TX 3
#define FONA_RST 4 //sms
//#define FONA_KEY 5 Power

#include <SoftwareSerial.h>
SoftwareSerial fonaSS = SoftwareSerial(FONA_TX, FONA_RX);
SoftwareSerial *fonaSerial = &fonaSS;
Adafruit_FONA fona = Adafruit_FONA(FONA_RST);

#define phoneNumber "+639958714814"

int textconfirm;
uint8_t type;
void setup() {
  // initialize serial communications and wait for port to open:
  Serial.begin(115200);
  while (!Serial) {
    ; // wait for serial port to connect. Needed for native USB port only
  }

  Serial.println("SMS Messages Sender");
  fonaSerial->begin(4800);
  if (! fona.begin(*fonaSerial)) {
    Serial.println(F("Couldn't find FONA"));
    while (1);
  }
  Serial.println(F("FONA is OK"));
  Serial.print(F("Found "));
}

void loop() {
 
  String location = gps();
  String messages = location;
  char txt[messages.length() - 1];
  messages.toCharArray(txt, messages.length());
  
  if (textconfirm>>1){
  Serial.println(txt);
  flushSerial();
    Serial.println(phoneNumber);
    Serial.println(txt);
    if (!fona.sendSMS(phoneNumber, txt)) {
    Serial.println(F("Failed"));
    } else {
    Serial.println(F("Sent!"));
    }
    Serial.println("\nCOMPLETE!\n");
    fona.enableGPS(false);
    delay(3600000);
  }else{
    Serial.println(F("No GPS Fix"));
    fona.enableGPS(false);
    delay(5000);
  }
}
void flushSerial() {
  while (Serial.available())
    Serial.read();
}
String gps() {
  
  String lat, lon;
  Serial.println(F("Enabling GPS..."));
  
  
  fona.enableGPS(true);
  delay(2000);
  float latitude, longitude;
  
  int8_t stat;

  //checks GPS fix status
  stat = fona.GPSstatus();
  if (stat<2){
    Serial.println(F("Failed to query"));
    textconfirm=0;    
  }else {while (!fona.getGPS(&latitude, &longitude)); 
  // if you ask for an altitude reading, getGPS will return false if there isn't a 3D fix
  lat = String(latitude, 6);
  lon = String(longitude, 6);
  return "Latitude: " + lat + "\nLongitude: " + lon;
  }
}

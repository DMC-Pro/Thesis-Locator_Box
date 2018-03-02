#include <VirtualWire.h>

char inData[50];
int newmessage = 0;

void setup() {
  // put your setup code here, to run once:
  vw_setup(2000);
  vw_set_tx_pin(12);
  Serial.begin(9600);

}

void loop() {
  // put your main code here, to run repeatedly:
  char inChar;
  byte index = 0;
  char mss[20];
    while(Serial.available() > 1){
      if (index < 49){
        delay(10);
        inChar = Serial.read();
        inData[index] = inChar;
        index++;
        inData[index] = '\0';
      }
      newmessage = 1;
    }
      if(newmessage == 1){
        inData[0] = '-';
        sprintf(mss, "%s", inData);
        vw_send((uint8_t *)mss, strlen(mss));
        vw_wait_tx();
        Serial.println(mss);
        delay(600);
        newmessage = 0;
      }
  

}

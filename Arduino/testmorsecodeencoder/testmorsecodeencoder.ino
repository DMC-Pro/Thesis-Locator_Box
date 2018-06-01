//Define the LED Pin
#define PIN_OUT 9
#define Power 4
#define PTT 5

//Define unit length in ms
#define UNIT_LENGTH 70
#define PWMdit 200
#define PWMdash 200
char input;
int i;
//Build a struct with the morse code mapping
static const struct {const char letter, *code;} MorseMap[] =
{
  { 'A', ".-" },
  { 'B', "-..." },
  { 'C', "-.-." },
  { 'D', "-.." },
  { 'E', "." },
  { 'F', "..-." },
  { 'G', "--." },
  { 'H', "...." },
  { 'I', ".." },
  { 'J', ".---" },
  { 'K', ".-.-" },
  { 'L', ".-.." },
  { 'M', "--" },
  { 'N', "-." },
  { 'O', "---" },
  { 'P', ".--." },
  { 'Q', "--.-" },
  { 'R', ".-." },
  { 'S', "..." },
  { 'T', "-" },
  { 'U', "..-" },
  { 'V', "...-" },
  { 'W', ".--" },
  { 'X', "-..-" },
  { 'Y', "-.--" },
  { 'Z', "--.." },
  { ' ', "     " }, //Gap between word, seven units 
    
  { '1', ".----" },
  { '2', "..---" },
  { '3', "...--" },
  { '4', "....-" },
  { '5', "....." },
  { '6', "-...." },
  { '7', "--..." },
  { '8', "---.." },
  { '9', "----." },
  { '0', "-----" },
    
  { '.', "·–·–·–" },
  { ',', "--..--" },
  { '?', "..--.." },
  { '!', "-.-.--" },
  { ':', "---..." },
  { ';', "-.-.-." },
  { '(', "-.--." },
  { ')', "-.--.-" },
  { '"', ".-..-." },
  { '@', ".--.-." },
  { '&', ".-..." },
};

void setup()
{
  pinMode( PIN_OUT, OUTPUT );
  digitalWrite( PIN_OUT, LOW );
  
  Serial.begin(9600);  
  digitalWrite(Power,LOW);
  digitalWrite(PTT,LOW);
  pinMode( PIN_OUT, OUTPUT );
}

void loop()
{
  String morseWord = encode( "SOS" );
  input = Serial.read();  
  switch(input)
  {
     case '1':
      digitalWrite(Power,HIGH);
      Serial.print("Input: ");
      Serial.println(input);
      break;
     case '2':
      digitalWrite(Power,LOW) ;
      Serial.print("Input: ");
      Serial.println(input);
      break;  
     case '3':
      digitalWrite(PTT,HIGH);
      Serial.print("Input: ");
      Serial.println(input);
      for (int j=0; j<=5; j++)
      {  
        for(int i=0; i<=morseWord.length(); i++)
        {
          Serial.println(morseWord[i]);
          switch( morseWord[i] )
          {
            case '.': //dit
              analogWrite( PIN_OUT, PWMdit );
              delay( UNIT_LENGTH );
              analogWrite( PIN_OUT, 0 );
              delay( UNIT_LENGTH );   
              break;
      
            case '-': //dah
              analogWrite( PIN_OUT, PWMdash );
              delay( UNIT_LENGTH*3 );
              analogWrite( PIN_OUT, 0 );
              delay( UNIT_LENGTH*3 );
                
              break;
      
            case ' ': //gap
              delay( UNIT_LENGTH );
          }
        }
      }
      Serial.println("Finished");
      break;
  
     case '4':
      digitalWrite(PTT,LOW);
      Serial.print("Input: ");
      Serial.println(input);
      break;
  }

}

String encode(const char *string)
{
  size_t i, j;
  String morseWord = "";
  
  for( i = 0; string[i]; ++i )
  {
    for( j = 0; j < sizeof MorseMap / sizeof *MorseMap; ++j )
    {
      if( toupper(string[i]) == MorseMap[j].letter )
      {
        morseWord += MorseMap[j].code;
        break;
      }
    }
    morseWord += " "; //Add tailing space to seperate the chars
  }

  return morseWord;  
}


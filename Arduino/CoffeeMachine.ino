#include <TimeAlarms.h>
#include <Time.h>

#define relay 7   // relay 
#define pingPin 9 // ultrasound input
#define pingOut 10 //ultrasound output

void setup(){
  
   //Setup relay and time
   pinMode(relay, OUTPUT);
   Serial.begin(9600); // open serial
   
   digitalWrite(relay,HIGH);
   delay(2000); //Wait 2 seconds before starting sequence
   setTime(1);//set time to program coffee maker
  
  
 }
 
 
 void loop(){
 
  
  Alarm.delay(1000);
  int cmd;
  while (Serial.available() > 0)
  {
    cmd = Serial.read();
      
    if(cmd == 49){ // if "1" in ASCII
        turnOn();
    }else if (cmd == 48){// if "0" in ASCII
       
        digitalWrite(relay, HIGH);   //turn off the relay
        Serial.println("0");//turned off
    }else if(cmd = 50){
         
          delay(3000);//wait to receive data
                   
          int seconds = Serial.parseInt();//read value from php
          Serial.println(seconds);
          
          Alarm.timerOnce(seconds, turnOn ); //set alarm
                  
    }else{
         Serial.println("Something went wrong");
    }
  } 
 }
 long sendSignal(){
  // establish variables for duration of the ping, 
  // and the distance result in centimeters:
  long duration;

   // Give a short LOW pulse beforehand to ensure a clean HIGH pulse:
  pinMode(pingOut, OUTPUT);
  digitalWrite(pingOut, LOW);
  delayMicroseconds(2);
  digitalWrite(pingOut, HIGH);
  delayMicroseconds(5);
  digitalWrite(pingOut, LOW);

  pinMode(pingPin, INPUT); //read the signal sent
  duration = pulseIn(pingPin, HIGH); 
  
  return microsecondsToCentimeters(duration);
 }
 
 long microsecondsToCentimeters(long microseconds)
{
  // The speed of sound is 340 m/s or 29 microseconds per centimeter.
  // The ping travels out and back, so to find the distance of the
  // object we take half of the distance travelled.
  return microseconds / 29 / 2;
}

void turnOn(){
  
 long cm = sendSignal(); //send ultrasound signal, only turn on if there is enough water
        if(cm<=16){
          Serial.println("Coffee maker is turned on");//there are at least 1 cup of water
          Serial.flush();//wait to send all data
          digitalWrite(relay, LOW);  //turn on
          
      }else if(cm >= 21){
          delay(1000);
          Serial.println("No water");//no water
          Serial.flush();
        }else{
           Serial.println("Try at least 1 cup.");//lest that 1 cup of water
           Serial.flush();
        } 
}



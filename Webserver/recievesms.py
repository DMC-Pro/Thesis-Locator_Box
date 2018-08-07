import serial
import RPi.GPIO as GPIO
import os, time

# Find a suitable character in a text or string and get its position
def find(str, ch):
    for i, ltr in enumerate(str):
        if ltr == ch:
            yield i

GPIO.setmode(GPIO.BOARD)

# Enable Serial Communication
port = serial.Serial("/dev/ttyAMA0", baudrate=9600, timeout=1)

# Transmitting AT Commands to the Modem
# '\r\n' indicates the Enter key

port.write('AT'+'\r\n')
port.write("\x0D\x0A")
rcv = port.read(10)
print rcv
time.sleep(1)

port.write('ATE0'+'\r\n')                 # Disable the Echo
rcv = port.read(10)
print rcv
time.sleep(1)

port.write('AT+CMGF=1'+'\r\n')            # Select Message format as Text mode
rcv = port.read(10)
print rcv
time.sleep(1)

port.write('AT+CNMI=2,1,0,0,0'+'\r\n')      # New SMS Message Indications
rcv = port.read(10)
print rcv
time.sleep(1)

ck=1
while ck==1:
    rcv = port.read(10)
    print rcv
    fd=rcv
    if len(rcv)&gt;3:                   # check if any data received
        ck=12
        for i in range(5):
            rcv = port.read(10)
            print rcv
            fd=fd+rcv                 # Extract the complete data

# Extract the message number shown in between the characters "," and '\r'

        p=list(find(fd, ","))
        q=list(find(fd, '\r'))
        MsgNo=fd[p[0]+1:q[1]]

# Read the message corresponds to the message number
        rd=port.write('AT+CMGR='+MsgNo+'\r\n')
        msg=''
        for j in range(10):
            rcv = port.read(20)
            msg=msg+rcv
        print msg
    time.sleep(0.1)
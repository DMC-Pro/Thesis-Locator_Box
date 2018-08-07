import serial

with serial.Serial() as gsm:
    gsm.baudrate = 9600
    gsm.port = "/dev/Serial0"
    gsm.timeout = 10
    gsm.open()
    if gsm.is_open:
        while True:
            command = input("Enter your Command: ")
            command = command.uppper()
            gsm.write(b'command')
            gsm.readlines()
import sys
from sense_hat import SenseHat
import time
import requests
import json

sense = SenseHat()
temp_adjust = 16
add_meting_url = "http://IP/nerdygadgets/AddTempMeting"
meting_time = 10

def saveGUID(guid_to_save):
    f = open("guid.txt", "w")
    f.write(guid_to_save)
    f.close()
    
def getGUID():
    f = open("guid.txt", "r")
    line = f.read()
    print(f.read())
    f.close()
    line = line.strip('\n')
    line = line.strip('\t')
    return line

guid = getGUID()

while True:
    time_begin = time.time()
    value = round(sense.get_temperature()-temp_adjust, 1)
    print (guid)
    
    url = add_meting_url+"?meting="+str(value)+"&guid="+str(guid)
    

    response = requests.post(url)
    res_json = json.loads(response.text)
    for key, value in res_json.items():
        if (key == 'guid'):
            guid = value
            saveGUID(value)
            print ("Successfully added temp")
        else:
            print ("Error: " + value)
    
    time_done = time.time()
    time_exp = time_done - time_begin
    time.sleep(meting_time - time_exp)
    



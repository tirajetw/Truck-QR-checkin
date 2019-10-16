import paho.mqtt.client as mqttClient
import time
import urllib, json
import requests
line_url = 'https://notify-api.line.me/api/notify'
token = 'eOw9XjtnbAHPaLMYSR4nZoiG43bDfiLTELBMnb5vRQG'
headers = {'content-type':'application/x-www-form-urlencoded','Authorization':'Bearer '+token}

centerLocation = "14.094272,100.521485"
def on_connect(client, userdata, flags, rc):
 
    if rc == 0:
 
        print("Connected to broker")
 
        global Connected                #Use global variable
        Connected = True                #Signal connection 
 
    else:
 
        print("Connection failed")
 
def on_message(client, userdata, message):
    print "\nLocation Check-In received: "  + message.payload
    data = message.payload
    data = map(float, data.split(','))
    url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=" + str(data[1]) + "," + str(data[2]) + "&destinations=" + centerLocation + "&key=AIzaSyDR5SxRmQaN3h5Ow4T-Gaojrg9M_3iNP3I"
    print "Request JSON from : " + url
    response = urllib.urlopen(url)
    json_data = json.loads(response.read())
    for k, v in json_data.items():
        print(k, v)

    msg = "ID" + str(int(data[0])) + " is " + json_data['rows'][0]['elements'][0]['distance']['text'] + ". away and will arrive in " + json_data['rows'][0]['elements'][0]['duration']['text']
    r = requests.post(line_url, headers=headers , data = {'message':msg})
    print r.text

Connected = False   #global variable for the state of the connection
 
broker_address= "202.28.244.147"  #Broker address
port = 1883                         #Broker port
user = "scn"                    #Connection username
password = "df2831"            #Connection password
topic = "truck/checkin"
client = mqttClient.Client("Python")               #create new instance
client.username_pw_set(user, password=password)    #set username and password
client.on_connect= on_connect                      #attach function to callback
client.on_message= on_message                      #attach function to callback
 
client.connect(broker_address, port=port)          #connect to broker
 
client.loop_start()        #start the loop

while Connected != True:    #Wait for connection
    time.sleep(0.1)
 
client.subscribe(topic)
 
try:
    while True:
        time.sleep(1)
 
except KeyboardInterrupt:
    print "exiting"
    client.disconnect()
    client.loop_stop()
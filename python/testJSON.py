import paho.mqtt.client as mqttClient
import time
import urllib, json
import requests

url = "https://maps.googleapis.com/maps/api/distancematrix/json?units=metric&origins=18.77921973617923,98.95117384865755&destinations=18.7956917,98.9506844&key=AIzaSyDR5SxRmQaN3h5Ow4T-Gaojrg9M_3iNP3I"
print "Request JSON from : " + url
response = urllib.urlopen(url)
json_data = json.loads(response.read())
for k, v in json_data.items():
    print(k, v)

msg = "ID" + "111" + " will arrive in "
print(json_data['rows'][0]['elements'][0]['distance']['text']) 
import requests
import time
import numpy as np
import math

numberOfTest = 10    # Hier Anzahl der Messungen eintragen

# Hier url eintragen
url = "https://api.openrouteservice.org/directions?api_key=58d904a497c67e00015b45fc9298e8d961e64b48b066a43e51d39887&coordinates=8.34234%2C48.23424%7C8.34423%2C48.26424&profile=driving-car"

rate_limit_lst = []
response_error_lst = []

counter = 0
while(True):
    res = requests.get(url)
    response = res.status_code
    if(response == 200):
        print(response)
        counter += 1
        #time.sleep(1.3)
    else:
        rate_limit_lst.append(counter)
        response_error_lst.append(response)
        print("Error response: ", response)
        print("Total number of requests until error: ", counter)
        counter = 0
        if (len(rate_limit_lst) >= numberOfTest):
            break
        else:
            print("Wait for next measurement...")
        time.sleep(60)

file = open("rate_limit_testing_report", "w")
rate_limit_array = np.array(rate_limit_lst)
mean = np.mean(rate_limit_array)
std = np.std(rate_limit_array)
mean_error = std / math.sqrt(len(rate_limit_array))
file.write("mean: " + str(mean) + "\n")
file.write("mean error: " + str(mean_error) + "\n")
file.write("Order of columns: Number of requests until error, error response" + "\n")
for i in range(len(rate_limit_lst)):
    file.write(str(rate_limit_lst[i]) + " "*4 + str(response_error_lst[i]) + "\n")
file.close()

import os, json, csv


path_to_json = 'developers_tmp'
json_files = [pos_json for pos_json in os.listdir(path_to_json) if pos_json.endswith('.json')]
print len(json_files)  # for me this prints ['foo.json']

with open('tyk_developers.csv', 'wb') as outcsv:
    writer = csv.writer(outcsv)
    writer.writerow(["Username", "Email"])

    for js in json_files:
        with open(os.path.join(path_to_json, js)) as json_file:
            devs = json.load(json_file)['Data']
            for dev in devs:
                if dev["fields"].has_key("Name"):
                    username = dev["fields"]["Name"]
                    email = dev["email"]
                else:
                    username = dev["email"]
                    email = dev["email"]

                #default_password = "change_password"
                writer.writerow([username.encode('utf-8'), email.encode('utf-8')])




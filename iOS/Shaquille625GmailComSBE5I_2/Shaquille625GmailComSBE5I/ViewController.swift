//
// Please report any problems with this app template to contact@estimote.com
//

import UIKit
import CoreLocation
import Alamofire

class ViewController: UIViewController, CLLocationManagerDelegate, ESTBeaconManagerDelegate {
    let URL_USER_REGISTER = "http://192.168.3.6/MyWebService/V1/personlocation.php"
    let URL_USER_LOCATION = "http://192.168.3.6/MyWebService/V1/location.php"
    let defaultValues = UserDefaults.standard
    
    @IBOutlet weak var labelMessage: UILabel!
    @IBOutlet weak var beaconLable: UILabel!
    @IBOutlet weak var labelUserName: UILabel!
    
    @IBAction func buttonLogout(_ sender: UIButton) {
        
        UserDefaults.standard.removePersistentDomain(forName: Bundle.main.bundleIdentifier!)
        UserDefaults.standard.synchronize()
        
        //switching to login screen
        let loginViewController = self.storyboard?.instantiateViewController(withIdentifier: "LoginViewController") as! LoginViewController
        self.navigationController?.pushViewController(loginViewController, animated: true)
        self.dismiss(animated: false, completion: nil)
    }
    

    
    
    let locationManager = CLLocationManager()
    let beaconManager = ESTBeaconManager()
    let region = CLBeaconRegion(proximityUUID: UUID(uuidString: "B9407F30-F5F8-466E-AFF9-25556B57FE6D")!, identifier: "Estimotes")
    let colors = [
        51217: UIColor(red: 247/255, green: 173/255, blue: 243/255, alpha: 1),
        27342: UIColor(red: 163/255, green: 71/255,  blue: 77/255, alpha: 1),
        29031: UIColor(red: 230/255, green: 242/255, blue: 106/255, alpha: 1)
    ]
    
    let placesByBeacons = [
        "44341:29031": [
            "Heavenly Sandwiches": 50, // read as: it's 50 meters from
            // "Heavenly Sandwiches" to the beacon with
            // major 6574 and minor 54631
            "Green & Green Salads": 150,
            "Mini Panini": 325
        ],
        "51025:27342": [
            "Heavenly Sandwiches": 250,
            "Green & Green Salads": 100,
            "Mini Panini": 20
        ],
        "46788:51217": [
            "Heavenly Sandwiches": 350,
            "Green & Green Salads": 500,
            "Mini Panini": 170
        ]
    ]
    override func viewDidLoad() {
        super.viewDidLoad()
        //hiding back button
        let backButton = UIBarButtonItem(title: "", style: UIBarButtonItemStyle.plain, target: navigationController, action: nil)
        navigationItem.leftBarButtonItem = backButton
        
        //getting user data from defaults
        let defaultValues = UserDefaults.standard
        if let name = defaultValues.string(forKey: "username"){
            //setting the name to label
            labelUserName.text = name
        }else{
            //send back to login view controller
        }
        // Do any additional setup after loading the view, typically from a nib.
        locationManager.delegate = self
        self.beaconManager.delegate = self
        self.beaconManager.requestAlwaysAuthorization()
        
        if (CLLocationManager.authorizationStatus() != CLAuthorizationStatus.authorizedWhenInUse){
            locationManager.requestWhenInUseAuthorization()
        }
        locationManager.startRangingBeacons(in: region)
        
    }
    
    override func didReceiveMemoryWarning() {
        super.didReceiveMemoryWarning()
        // Dispose of any resources that can be recreated.
    }
    
    
    override func viewWillAppear(_ animated: Bool) {
        super.viewWillAppear(animated)
        self.beaconManager.startRangingBeacons(in: self.region)
    }
    
    override func viewDidDisappear(_ animated: Bool) {
        super.viewDidDisappear(animated)
        self.beaconManager.stopRangingBeacons(in: self.region)
    }
    
    func placesNearBeacon(_ beacon: CLBeacon) -> [String]? {
        let beaconKey = "\(beacon.major):\(beacon.minor)"
        if let places = self.placesByBeacons[beaconKey] {
            let sortedPlaces = Array(places).sorted { $0.1 < $1.1 }.map { $0.0 }
            return sortedPlaces
        }
        return nil
    }
    
    func beaconManager(_ manager: Any, didRangeBeacons beacons: [CLBeacon],
                       in region: CLBeaconRegion) {
        let knownBeacons = beacons.filter{ $0.proximity != CLProximity.unknown }
        
        
        if (knownBeacons.count > 0) {
            let closestBeacon = knownBeacons[0] as CLBeacon
            self.view.backgroundColor = self.colors[closestBeacon.minor.intValue]
            if(closestBeacon.minor.intValue == 29031){
                beaconLable.text = "Library"
                
            }
            if(closestBeacon.minor.intValue == 27342){
                beaconLable.text = "Gym"
                
            }
            if(closestBeacon.minor.intValue == 51217){
                beaconLable.text = "Activity Center"
                
            }
            
        }
        
        
    }
    
    @IBAction func sendLocation(_ sender: UIButton) {
        
        var parameters = [String:Any]()
        let userName = defaultValues.string(forKey: "username")
        let usernamePar: Parameters=[
            "username":userName!
        ]
        
        
        
        
        Alamofire.request(URL_USER_LOCATION, method: .post, parameters: usernamePar).responseJSON
            {
                response in
                //printing response
                print(response)
                
                //getting the json value from the server
                if let result = response.result.value {
                    let jsonData = result as! NSDictionary
                    
                    //if there is no error
                    if(!(jsonData.value(forKey: "error") as! Bool)){
                        
                        //getting the user from response
                        
                        let userLocation = jsonData.value(forKey: "location") as! NSDictionary
                        let library = userLocation.value(forKey: "library") as! Int
                        let gym = userLocation.value(forKey: "gym") as! Int
                        let activitycenter = userLocation.value(forKey: "activitycenter") as! Int
                        
                        self.defaultValues.set(library, forKey: "library")
                        self.defaultValues.set(gym, forKey: "gym")
                        self.defaultValues.set(activitycenter, forKey: "activitycenter")
                        
                        
                    }else{
                        //error message in case of invalid credential
                        self.labelMessage.text = "Invalid Data"
                    }
                }
        }
        print (defaultValues.integer(forKey: "activitycenter"))
        
        if(beaconLable.text == "Library"){
            parameters=[
                "id":defaultValues.integer(forKey: "userid"),
                "library":defaultValues.integer(forKey: "library")+1,
                "gym":defaultValues.integer(forKey: "gym"),
                "activitycenter":defaultValues.integer(forKey: "activitycenter")
                
            ]
        }else if(beaconLable.text == "Gym"){
            parameters=[
                "id":defaultValues.integer(forKey: "userid"),
                "library":defaultValues.integer(forKey: "library"),
                "gym":defaultValues.integer(forKey: "gym")+1,
                "activitycenter":defaultValues.integer(forKey: "activitycenter")
                
            ]
        }else{
            parameters=[
                "id":defaultValues.integer(forKey: "userid"),
                "library":defaultValues.integer(forKey: "library"),
                "gym":defaultValues.integer(forKey: "gym"),
                "activitycenter":defaultValues.integer(forKey: "activitycenter")+1
                
            ]
        }
        print (type(of: parameters))
        
        
        Alamofire.request(URL_USER_REGISTER, method: .post, parameters: parameters).responseJSON
            {
                response in
                //printing response
                print(response)
                
                //getting the json value from the server
                if let result = response.result.value {
                    
                    //converting it as NSDictionary
                    let jsonData = result as! NSDictionary
                    
                    //displaying the message in label
                    self.labelMessage.text = jsonData.value(forKey: "message") as! String?
                }
        }
        
    }
    
    /*
     func locationManager(_ manager: CLLocationManager, didRangeBeacons beacons: [CLBeacon], in region: CLBeaconRegion) {
     let knownBeacons = beacons.filter{ $0.proximity != CLProximity.unknown }
     if (knownBeacons.count > 0) {
     let closestBeacon = knownBeacons[0] as CLBeacon
     self.view.backgroundColor = self.colors[closestBeacon.minor.intValue]
     }
     }*/
    
    
}

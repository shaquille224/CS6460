import UIKit

@UIApplicationMain
class AppDelegate: UIResponder, UIApplicationDelegate, ESTBeaconManagerDelegate {
    
    var window: UIWindow?
    let beaconManager = ESTBeaconManager()
    
    func application(_ application: UIApplication, didFinishLaunchingWithOptions launchOptions: [UIApplicationLaunchOptionsKey: Any]?) -> Bool {
        self.beaconManager.delegate = self
        self.beaconManager.requestAlwaysAuthorization()
        
        ESTConfig.setupAppID("shaquille625-gmail-com-s-b-e5i", andAppToken: "43e758424698417067ecc41cc406b828")
        
        
        ESTAnalyticsManager.enableRangingAnalytics(true)
        ESTAnalyticsManager.enableMonitoringAnalytics(true)
        
        self.beaconManager.startRangingBeacons(in: CLBeaconRegion(
            proximityUUID: UUID(uuidString: "B9407F30-F5F8-466E-AFF9-25556B57FE6D")!,
            identifier: "Estimotes"))
        UIApplication.shared.registerUserNotificationSettings(
            UIUserNotificationSettings(types: .alert, categories: nil))
        // Override point for customization after application launch.
        return true
    }
    
    func applicationDidFinishLaunching(_ application: UIApplication) {
        self.beaconManager.requestWhenInUseAuthorization()
        // ... above this:
        self.beaconManager.startRangingBeacons(in: CLBeaconRegion(proximityUUID: NSUUID(uuidString: "B9407F30-F5F8-466E-AFF9-25556B57FE6D")! as UUID, identifier: "Estimotes"))
    }
    
    func applicationWillResignActive(_ application: UIApplication) {
        // Sent when the application is about to move from active to inactive state. This can occur for certain types of temporary interruptions (such as an incoming phone call or SMS message) or when the user quits the application and it begins the transition to the background state.
        // Use this method to pause ongoing tasks, disable timers, and throttle down OpenGL ES frame rates. Games should use this method to pause the game.
    }
    
    func applicationDidEnterBackground(_ application: UIApplication) {
        // Use this method to release shared resources, save user data, invalidate timers, and store enough application state information to restore your application to its current state in case it is terminated later.
        // If your application supports background execution, this method is called instead of applicationWillTerminate: when the user quits.
    }
    
    func applicationWillEnterForeground(_ application: UIApplication) {
        // Called as part of the transition from the background to the inactive state; here you can undo many of the changes made on entering the background.
    }
    
    func applicationDidBecomeActive(_ application: UIApplication) {
        // Restart any tasks that were paused (or not yet started) while the application was inactive. If the application was previously in the background, optionally refresh the user interface.
    }
    
    func applicationWillTerminate(_ application: UIApplication) {
        // Called when the application is about to terminate. Save data if appropriate. See also applicationDidEnterBackground:.
    }
    
}


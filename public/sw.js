let url = 'http://localhost/erp/public/libraries/tas-lib/audio/suara.wav'
self.addEventListener('push', function (e) {

    if (!(self.Notification && self.Notification.permission === 'granted')) {
        console.log("notifications aren't supported or permission not granted!")
        return;
    }
    
    if (e.data) {
        var msg = e.data.json();
        console.log("msg",msg);
      
        e.waitUntil(self.registration.showNotification(msg.title, {
            body: msg.body,
            icon: msg.icon,
            sound: url,
            actions: [
                {
                  action: 'view-order',
                  type: 'button',
                  title: 'view order',
                },
              ],
           
        }));
    }
});

self.addEventListener('notificationclick', function(event) {
    event.notification.close();
    
    // var action = event.notification.data.action;
    // if (action === 'yes') {
    //     // Lakukan tindakan yang sesuai, seperti membuka aplikasi.
    //     // Anda dapat menavigasi ke URL atau melakukan tindakan lainnya di sini.
    //     clients.openWindow('localhost/erp/login');
    // }
    if (!event.action) {
        // Was a normal notification click
        console.log('Notification Click.');
        clients.openWindow('/erp/pesananfinalheader');
        return;
      }
    
      switch (event.action) {
        case 'view-order':
          clients.openWindow('/erp/pesananfinalheader');
          break;
        default:
          console.log(`Unknown action clicked: '${event.action}'`);
          break;
      }
});
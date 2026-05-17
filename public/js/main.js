document.addEventListener('DOMContentLoaded', function() {
    
    const alerts = document.querySelectorAll('.alert-success');
    alerts.forEach(function(alert) {
        
        if (alert.id !== 'ajax-notification') {
            setTimeout(function() {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                setTimeout(() => alert.remove(), 500); 
            }, 4000);
        }
    });

    const currentUrl = window.location.href;
    const sidebarLinks = document.querySelectorAll('.sidebar-nav a');
    
    sidebarLinks.forEach(function(link) {
        if (currentUrl.includes(link.getAttribute('href'))) {
            link.style.backgroundColor = 'rgba(255,255,255,0.2)';
            link.style.color = '#ffffff';
            link.style.fontWeight = 'bold';
            link.style.borderLeft = '4px solid #17a2b8'; 
        }
    });

});



function processTransfer(transferId, action) {
    if (!confirm('Are you sure you want to mark this transfer as ' + action + '?')) {
        return;
    }

    const payload = {
        transfer_id: transferId,
        action: action
    };

    fetch('index.php?controller=transfer&action=processAjax', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(payload)
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        const notification = document.getElementById('ajax-notification');
        
        if (data.status === 'success') {
            notification.className = 'alert alert-success';
            notification.innerHTML = data.message;
            notification.style.display = 'block';
            notification.style.opacity = '1';

            const row = document.getElementById('transfer-row-' + transferId);
            if (row) {
                row.style.transition = "background-color 0.5s ease, opacity 0.5s ease";
                row.style.backgroundColor = action === 'approved' ? '#d4edda' : '#f8d7da';
                
                setTimeout(() => {
                    row.style.opacity = '0';
                    setTimeout(() => {
                        row.remove();
                        checkEmptyTable();
                    }, 500);
                }, 500);
            }
        } else {
            notification.className = 'alert alert-danger';
            notification.innerHTML = data.message;
            notification.style.display = 'block';
        }
        
        setTimeout(() => {
            notification.style.opacity = '0';
            setTimeout(() => { notification.style.display = 'none'; }, 500);
        }, 3000);
    })
    .catch(error => {
        console.error('AJAX Error:', error);
        alert('A network error occurred while processing the request. Check your console for details.');
    });
}


function checkEmptyTable() {
    const tbody = document.querySelector('#transfers-table tbody');
    if (tbody && tbody.children.length === 0) {
        document.getElementById('transfers-table').style.display = 'none';
        
        let emptyState = document.getElementById('empty-state-msg');
        if (!emptyState) {
            const panel = document.querySelector('.panel');
            panel.innerHTML += '<div class="empty-state" id="empty-state-msg"><p>There are no pending transfer requests for your branches at this time.</p></div>';
        }
    }
}
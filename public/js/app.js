//Liste des membres
function getMembers(){
    let members = null;
    $.get('/dashboard/form/data/members', function(data) {
        members = data;
    });
    return members;
}

// Liste des cotisations (via AJAX Laravel)
function getContributions(){
    let contributions = null;
    $.get('/dashboard/form/data/contributions', function(data) {
        contributions = data;
    });
    return contributions;
}


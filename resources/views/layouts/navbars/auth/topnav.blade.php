@push('css')
<style>
    .navbar-search-block .input-group {
        width: 100%;
        min-width: 250px;
    }
    
    .navbar-search-block {
        width: auto;
        max-width: 400px;
        margin-right: 20px; 
    }
    
    .navbar-search-block .form-control {
        width: 100%; 
    }
    
    #navbar {
        overflow: visible
    }
    
    #searchSuggestions .dropdown-item {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        white-space: normal; 
    } 
    
    #searchSuggestions .dropdown-item {
        padding: 10px 15px;
        border-bottom: 1px solid rgba(0,0,0,0.05);
        white-space: normal;
    }
    
    #searchSuggestions .dropdown-item:last-child {
        border-bottom: none;
    }
    
    #searchSuggestions .dropdown-item:hover {
        background-color: rgba(94, 114, 228, 0.1);
    }
    
    #searchSuggestions .dropdown-item i {
        margin-right: 10px;
        color: #5e72e4;
    }
    
    #searchSuggestions .dropdown-item small {
        display: block;
        margin-top: 5px;
        color: #8898aa;
    }
</style>
@endpush

<!-- Navbar -->
<nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="false">
    <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center w-100">
        <div class="d-flex align-items-center">
            <h4 class="font-weight-bolder text-white mb-0">{{ $title }}</h4>
        </div>
        <div class="d-flex align-items-center justify-content-end flex-grow-1" id="navbar">
            <div class="navbar-search-block me-3">
                <div class="input-group rounded-pill overflow-hidden">
                    <span class="input-group-text text-body bg-white border-0">
                        <i class="fas fa-search" aria-hidden="true"></i>
                    </span>
                    <input type="text" class="form-control border-0" id="searchInput" placeholder="Search here..." style="border-radius: 0;">
                </div>
                <div class="dropdown-menu" id="searchSuggestions" style="display: none; max-height: 400px; overflow-y: auto; padding: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.2); border-radius: 10px; position: absolute; top: calc(100% + 10px); left: 0; width: 600px; z-index: 1050;">
                </div>
            </div>
            <ul class="navbar-nav d-flex flex-row align-items-center">
                <li class="nav-item dropdown pe-2 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fa fa-bell cursor-pointer"></i>
                    </a>
                </li>
                <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
                    <a href="javascript:;" class="nav-link text-white p-0" id="iconNavbarSidenav">
                        <div class="sidenav-toggler-inner">
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                            <i class="sidenav-toggler-line bg-white"></i>
                        </div>
                    </a>
                </li>
                <li class="nav-item d-flex align-items-center">
                    <form id="logout-form" action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="nav-link btn btn-link text-white font-weight-bold px-2 py-1 m-0" style="text-decoration: none;">
                            <i class="fa fa-user me-sm-1"></i>
                            <span class="d-sm-inline d-none">Log out</span>
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- End Navbar -->

@push('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    const suggestionsBox = document.getElementById('searchSuggestions');
    
    if (!searchInput || !suggestionsBox) {
        console.error("Search elements not found in the DOM");
        return;
    }
    
    console.log("Search elements initialized");
    
    searchInput.addEventListener('input', function() {
        const query = this.value.toLowerCase();
        console.log("Search query:", query);
        
        if (query.length < 2) {
            suggestionsBox.style.display = 'none';
            return;
        }
        
        // Make AJAX call to search endpoint
        console.log("Fetching search results for:", query);
        
        fetch('/api/search?query=' + encodeURIComponent(query))
            .then(response => {
                console.log("Search response status:", response.status);
                // Log the raw response for debugging
                response.clone().text().then(text => {
                    console.log("Raw response:", text);
                });
                
                if (!response.ok) {
                    throw new Error('Server returned ' + response.status);
                }
                return response.json();
            })
            .then(results => {
    console.log("Search results:", results);
    
    if (results && results.length > 0) {
        suggestionsBox.innerHTML = '';
        
        results.forEach(result => {
            // Get the query from the search input
            const query = searchInput.value.toLowerCase();
            
            // Highlight the query in the context
            let context = result.context;
            if (context && query.length > 1) {
                // Use a regex with 'gi' flags for global, case-insensitive matching
                const regex = new RegExp(query, 'gi');
                context = context.replace(regex, match => `<strong class="text-primary">${match}</strong>`);
            }
            
            suggestionsBox.innerHTML += `
                <a class="dropdown-item" href="${result.url}">
                    <i class="fas fa-file-alt mr-2"></i>
                    ${result.title}
                    <small class="text-muted ml-2">${context}</small>
                </a>
            `;
        });
        
        suggestionsBox.style.display = 'block';
    } else {
        suggestionsBox.innerHTML = `
            <span class="dropdown-item text-muted">
                No results found for "${searchInput.value}"
            </span>
        `;
        suggestionsBox.style.display = 'block';
    }
})

    });
    
    // Close suggestions on click outside
    document.addEventListener('click', function(e) {
        if (!e.target.closest('.navbar-search-block')) {
            suggestionsBox.style.display = 'none';
        }
    });
});

</script>
@endpush

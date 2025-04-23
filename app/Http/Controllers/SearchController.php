<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class SearchController extends Controller
{
    private $searchPaths = [
        'views' => 'views/*.blade.php',
        'pages' => 'views/pages/*.blade.php',
        'admin' => 'views/admin/*.blade.php',
        'auth' => 'views/auth/*.blade.php',
        'cashier' => 'views/cashier/*.blade.php',
        'components' => 'views/components/*.blade.php',
        'drugs' => 'views/drugs/*.blade.php',
        'expiry' => 'views/expiry/*.blade.php',
        'medical-assistant' => 'views/medical-assistant/*.blade.php',
        'pharmacist' => 'views/pharmacist/*.blade.php',
        'roles' => 'views/roles/*.blade.php',
        'sales' => 'views/sales/*.blade.php',
        'stock' => 'views/stock/*.blade.php',
        'suppliers' => 'views/suppliers/*.blade.php'
    ];

    private $routeMap = [
        'dashboard' => 'home',
        'drugs.index' => 'drugs.index',
        'suppliers.index' => 'suppliers.index',
        'stock.index' => 'stock.index',
        'stock.show' => 'stock.show',
        'receive.stock' => 'receive.stock',
        'stock.view' => 'stock.view',
        'approve.stock.orders' => 'approve.stock.orders',
        'near.expiry' => 'near.expiry',
        'expired.drugs' => 'expired.drugs',
        'disposed.drugs' => 'disposed.drugs',
        'finances' => 'finances',
        'roles.index' => 'roles.index',
        'user-management' => 'user-management',
        'profile' => 'profile'
    ];

    public function search(Request $request)
    {
        try {
            $query = strtolower(trim($request->input('query')));
            
            if (empty($query) || strlen($query) < 2) {
                return response()->json([]);
            }
            
            // For debugging
            Log::info('Search query: ' . $query);
            
            $results = [];
            
            foreach ($this->searchPaths as $type => $path) {
                $files = File::glob(resource_path($path));
                Log::info('Searching in path: ' . $path . ', found ' . count($files) . ' files');
                
                foreach ($files as $file) {
                    $content = file_get_contents($file);
                    
                    // Remove Blade directives and PHP code
                    $cleanedContent = $this->cleanBladeContent($content);
                    $text = strtolower($cleanedContent);
                    
                    if (strpos($text, $query) !== false) {
                        $fileName = basename($file, '.blade.php');
                        
                        // Use route name if mapped, otherwise fallback to file path
                        $url = isset($this->routeMap[$fileName]) 
                            ? route($this->routeMap[$fileName])
                            : url(str_replace('.', '/', $fileName));
    
                        $results[] = [
                            'title' => ucwords(str_replace('-', ' ', $fileName)),
                            'url' => $url,
                            'context' => $this->getMatchContext($text, $query),
                            'section' => ucfirst($type)
                        ];
                    }
                }
            }
            
            Log::info('Search results: ' . count($results));
            return response()->json($results);
        } catch (\Exception $e) {
            Log::error('Search error: ' . $e->getMessage());
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
    
   /**
 * Clean Blade template content to extract only visible text
 */
/**
 * Clean Blade template content to extract only visible text
 */
private function cleanBladeContent($content)
{
    // Remove Blade directives
    $content = preg_replace('/@(extends|section|endsection|include|yield|php|if|else|elseif|endif|foreach|endforeach|for|endfor|while|endwhile|push|endpush|stack|csrf|method|auth|guest|slot|endslot)\s*\([^)]*\)/', ' ', $content);
    $content = preg_replace('/@(else|endif|endforeach|endfor|endwhile|endpush|endslot|endsection|stop|show)/', ' ', $content);
    
    // Remove inline Blade expressions {{ ... }}
    $content = preg_replace('/\{\{(.+?)\}\}/', ' ', $content);
    
    // Remove Blade comments {{-- ... --}}
    $content = preg_replace('/\{\{--(.*?)--\}\}/s', ' ', $content);
    
    // Remove PHP code - more comprehensive pattern
    $content = preg_replace('/<\?php.*?\?>/s', ' ', $content);  // Standard PHP tags
    $content = preg_replace('/<\?.*?\?>/s', ' ', $content);     // Short PHP tags
    $content = preg_replace('/<\%.*?\%>/s', ' ', $content);     // ASP-style tags
    
    // Extract only text from common text tags
    $textContent = '';
    $textTags = ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'div', 'a', 'li', 'td', 'th', 'button', 'label', 'strong', 'em', 'b', 'i', 'small', 'blockquote', 'figcaption', 'caption'];
    
    // Create a pattern to match content inside text tags
    $pattern = '/<(' . implode('|', $textTags) . ')[^>]*>(.*?)<\/\1>/is';
    
    if (preg_match_all($pattern, $content, $matches)) {
        foreach ($matches[2] as $match) {
            // Recursively extract text from nested tags
            $innerText = strip_tags($match);
            if (!empty($innerText)) {
                $textContent .= ' ' . $innerText;
            }
        }
    }
    
    // If no text tags were found, fall back to a more basic extraction
    if (empty($textContent)) {
        // Extract text from any HTML tag
        if (preg_match_all('/<[a-z][^>]*>(.*?)<\/[a-z][^>]*>/is', $content, $matches)) {
            foreach ($matches[1] as $match) {
                $innerText = strip_tags($match);
                if (!empty($innerText)) {
                    $textContent .= ' ' . $innerText;
                }
            }
        }
    }
    
    // If still no content, use a very basic approach
    if (empty($textContent)) {
        $textContent = strip_tags($content);
    }
    
    // Clean up whitespace
    $textContent = preg_replace('/\s+/', ' ', $textContent);
    $textContent = trim($textContent);
    
    return $textContent;
}




    private function searchRoutes($query)
    {
        $results = [];
        
        // Get all named routes
        $routes = Route::getRoutes();
        
        foreach ($routes as $route) {
            $name = $route->getName();
            $uri = $route->uri();
            
            // Skip routes without names or that are API routes
            if (!$name || strpos($uri, 'api/') === 0) {
                continue;
            }
            
            $nameFormatted = str_replace('.', ' ', $name);
            $uriFormatted = str_replace('/', ' ', $uri);
            
            // Search in route name and URI
            if (strpos(strtolower($nameFormatted), $query) !== false || 
                strpos(strtolower($uriFormatted), $query) !== false) {
                
                try {
                    $url = route($name);
                    $results[] = [
                        'title' => ucwords($nameFormatted),
                        'url' => $url,
                        'context' => "Route: " . $uri,
                        'section' => 'Routes'
                    ];
                } catch (\Exception $e) {
                    // Skip routes that can't be generated (e.g., missing parameters)
                    continue;
                }
            }
        }
        
        return $results;
    }

    private function determineUrl($fileName, $relativePath)
    {
        // First check if we have a direct route mapping
        if (isset($this->routeMap[$fileName])) {
            try {
                return route($this->routeMap[$fileName]);
            } catch (\Exception $e) {
                // If route generation fails, fall back to URL
            }
        }
        
        // Check if there's a route with the same name as the path
        $routeName = str_replace('/', '.', $relativePath . '/' . $fileName);
        try {
            if (Route::has($routeName)) {
                return route($routeName);
            }
        } catch (\Exception $e) {
            // If route generation fails, fall back to URL
        }
        
        // Fall back to a URL based on the file path
        return url($relativePath . '/' . $fileName);
    }

    private function formatTitle($fileName, $relativePath)
    {
        // Format the title to be more user-friendly
        $title = str_replace('-', ' ', $fileName);
        
        // If the file is in a subdirectory, include that in the title
        if (!empty($relativePath) && $relativePath !== '.') {
            $section = basename($relativePath);
            $section = str_replace('-', ' ', $section);
            $title = ucwords($section) . ' - ' . ucwords($title);
        }
        
        return ucwords($title);
    }

    private function getMatchContext($text, $query, $length = 100)
{
    $position = strpos($text, $query);
    if ($position === false) return '';
    
    $start = max(0, $position - $length/2);
    $context = substr($text, $start, $length);
    
    // Clean up the context
    $context = preg_replace('/\s+/', ' ', $context); // Replace multiple spaces with a single space
    $context = trim($context);
    
    return '...' . $context . '...';
}

}

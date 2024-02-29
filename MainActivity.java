import android.os.Bundle;
import android.webkit.JsResult;
import android.webkit.WebChromeClient;
import android.webkit.WebSettings;
import android.webkit.WebView;
import android.webkit.WebViewClient;
import androidx.appcompat.app.AppCompatActivity;
import com.example.yourprojectname.R;
import com.google.android.material.dialog.MaterialAlertDialogBuilder;

public class WebViewActivity extends AppCompatActivity {

    private WebView webView;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_webview);

        webView = findViewById(R.id.webView);
        WebSettings webSettings = webView.getSettings();
        webSettings.setJavaScriptEnabled(true);

        // Set a WebViewClient to handle page navigation and loading
        webView.setWebViewClient(new WebViewClient());

        // Set a WebChromeClient to handle JavaScript dialog events
        webView.setWebChromeClient(new WebChromeClient() {
            @Override
            public boolean onJsAlert(WebView view, String url, String message, JsResult result) {
                // Handle the JavaScript alert using SweetAlert
                showSweetAlert(message);
                result.confirm();
                return true;
            }
        });

        // Load your HTML content
        webView.loadUrl("http://stockmanagement.cbi.local/userloginso.html");
    }

    private void showSweetAlert(String message) {
        new MaterialAlertDialogBuilder(this)
                .setTitle("Alert")
                .setMessage(message)
                .setPositiveButton("OK", (dialog, which) -> {
                    // Handle the positive button click
                })
                .show();
    }

    @Override
    public void onBackPressed() {
        if (webView.canGoBack()) {
            webView.goBack();
        } else {
            super.onBackPressed();
        }
    }
}

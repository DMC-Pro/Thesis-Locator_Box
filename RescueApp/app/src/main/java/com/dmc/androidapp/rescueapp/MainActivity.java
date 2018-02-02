package com.dmc.androidapp.rescueapp;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

public class MainActivity extends AppCompatActivity implements OnMapReadyCallback {

    private Toolbar mTopToolbar;

    EditText latitudeText;
    EditText longitudeText;
    TextView resultText;

    Marker rescuer;
    Marker device;

    @Override
    protected void onCreate(Bundle savedInstanceState) {


        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        // Get the SupportMapFragment and request notification
        // when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        mTopToolbar = findViewById(R.id.my_toolbar);
        setSupportActionBar(mTopToolbar);

        latitudeText = findViewById(R.id.editText4);
        longitudeText = findViewById(R.id.editText5);
        resultText =findViewById(R.id.textView5);

        findViewById(R.id.button3).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        try {
                            GlobalVar.loclat = Double.parseDouble(latitudeText.getText().toString());
                            GlobalVar.loclong = Double.parseDouble(longitudeText.getText().toString());
                            resultText.setText("New Coordinates Set:\n");
                            resultText.append("Latitude:  " + String.valueOf(GlobalVar.loclat) + "\n");
                            resultText.append("Longitude: " + String.valueOf(GlobalVar.loclong) + "\n");
                        }
                        catch (NumberFormatException e){
                            resultText.setText(e.getMessage());
                        }
                        try{
                            changeMarker();
                        }
                        catch (NullPointerException e){
                            resultText.setText(e.getMessage());
                        }
                    }
                }
        );

    }

    public void changeMarker(){
        LatLng device = new LatLng(GlobalVar.loclat, GlobalVar.loclong);
        rescuer.setPosition(device);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        //Proper values
        //  Positive Signed     Negative Signed
        //      North               South
        //      East                West
        //Example: 1°North 1°West is equal to (1, -1)
        LatLng lrt = new LatLng(14.6155575, 121.0814098);
        MarkerOptions marker = new MarkerOptions().position(lrt).title("Marker in LRT");
        rescuer = googleMap.addMarker(marker);
        googleMap.moveCamera(CameraUpdateFactory.newLatLng(lrt));
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        // Inflate the menu; this adds items to the action bar if it is present.
        getMenuInflater().inflate(R.menu.menu_main, menu);
        return true;
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        // Handle action bar item clicks here. The action bar will
        // automatically handle clicks on the Home/Up button, so long
        // as you specify a parent activity in AndroidManifest.xml.
        int id = item.getItemId();

        //noinspection SimplifiableIfStatement
        if (id == R.id.action_favorite) {
            Toast.makeText(MainActivity.this, "Menu clicked", Toast.LENGTH_LONG).show();
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

}

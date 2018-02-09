package com.dmc.androidapp.rescueapp;

import android.Manifest;
import android.content.Context;
import android.content.pm.PackageManager;
import android.location.Location;
import android.location.LocationManager;
import android.os.AsyncTask;
import android.os.Bundle;
import android.support.annotation.NonNull;
import android.support.v4.app.ActivityCompat;
import android.support.v7.app.AppCompatActivity;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.ProgressBar;
import android.widget.TextView;
import android.widget.Toast;

import com.google.android.gms.maps.CameraUpdateFactory;
import com.google.android.gms.maps.GoogleMap;
import com.google.android.gms.maps.OnMapReadyCallback;
import com.google.android.gms.maps.SupportMapFragment;
import com.google.android.gms.maps.model.LatLng;
import com.google.android.gms.maps.model.Marker;
import com.google.android.gms.maps.model.MarkerOptions;

import org.json.JSONException;
import org.json.JSONObject;
import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;

import java.io.IOException;

public class MainActivity extends AppCompatActivity implements OnMapReadyCallback {

    private Toolbar mTopToolbar;

    TextView resultText;
    TextView rescuerName;
    TextView rescuerTask;

    Marker rescuer;
    Marker device;

    ProgressBar loading;

    static final int REQUEST_LOCATION = 1;
    LocationManager locationManager;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        // Get the SupportMapFragment and request notification
        // when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        //initialize widgets
        resultText = findViewById(R.id.textView5);
        rescuerName = findViewById(R.id.textView7);
        rescuerTask = findViewById(R.id.textView8);
        mTopToolbar = findViewById(R.id.my_toolbar);
        setSupportActionBar(mTopToolbar);
        loading = findViewById(R.id.progressBar2);
        loading.setVisibility(View.INVISIBLE);

        //Set sometext in Main Activity
        rescuerName.append(GlobalVar.rescue_team_name);
        rescuerTask.append(GlobalVar.rescue_team_current_task);

        //Get Location
        locationManager = (LocationManager)getSystemService(Context.LOCATION_SERVICE);
        getLocation();

        findViewById(R.id.button3).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        new GetVictim().execute();
                    }
                }
        );
        findViewById(R.id.button4).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        getLocation();
                        changeMarker();
                    }
                }
        );
    }

    void getLocation() {
        if( ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_FINE_LOCATION)
                != PackageManager.PERMISSION_GRANTED && ActivityCompat.checkSelfPermission(this, Manifest.permission.ACCESS_COARSE_LOCATION)
                != PackageManager.PERMISSION_GRANTED) {

            ActivityCompat.requestPermissions(this, new String[]{Manifest.permission.ACCESS_FINE_LOCATION}, REQUEST_LOCATION);

        } else {
            Location[] location = {locationManager.getLastKnownLocation(LocationManager.GPS_PROVIDER),
                    locationManager.getLastKnownLocation(LocationManager.NETWORK_PROVIDER),
                    locationManager.getLastKnownLocation(LocationManager.PASSIVE_PROVIDER)
            };
            for(int i = 0; i < 3; i++){
                if (location[i] != null){
                    GlobalVar.RescuerLoc = "Found";
                    GlobalVar.RescuerLat = location[i].getLatitude();
                    GlobalVar.RescuerLong = location[i].getLongitude();
                    break;
                } else {
                    GlobalVar.RescuerLoc = "NotFound";
                }
            }

        }

    }

    @Override
    public void onRequestPermissionsResult(int requestCode, @NonNull String[] permissions, @NonNull int[] grantResults) {
        super.onRequestPermissionsResult(requestCode, permissions, grantResults);

        switch (requestCode) {
            case REQUEST_LOCATION:
                getLocation();
                break;
        }
    }

    public void changeMarker(){
        LatLng rescuerloc = new LatLng(GlobalVar.RescuerLat, GlobalVar.RescuerLong);
        rescuer.setPosition(rescuerloc);
        LatLng deviceloc = new LatLng(GlobalVar.loclat, GlobalVar.loclong);
        device.setPosition(deviceloc);
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        //Proper values
        //  Positive Signed     Negative Signed
        //      North               South
        //      East                West
        //Example: 1°North 1°West is equal to (1, -1)
        // Victim Location Set
        LatLng deviceloc = new LatLng(GlobalVar.DeviceLat, GlobalVar.DeviceLong);
        MarkerOptions devicemarker = new MarkerOptions().position(deviceloc).title("Victim");
        device = googleMap.addMarker(devicemarker);
        // Rescuer Location Set;
        LatLng rescuerloc = new LatLng(GlobalVar.RescuerLat, GlobalVar.RescuerLong);
        MarkerOptions rescuermarker = new MarkerOptions().position(rescuerloc).title("Rescuer");
        rescuer = googleMap.addMarker(rescuermarker);
        googleMap.moveCamera(CameraUpdateFactory.newLatLngZoom(rescuerloc, 15.0f));
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

    private class GetVictim extends AsyncTask<String, Void, String> {

        @Override
        protected String doInBackground(String... params) {
            final StringBuilder builder = new StringBuilder();
            try {
                Document doc = Jsoup.connect( "http://" + GlobalVar.localhostwifi + "/thesis/conn/")
                        .data("action", "getvictim")
                        .data("user", GlobalVar.rescue_team_current_task)
                        .userAgent("Mozilla")
                        .post();
                builder.append(doc.getElementsByTag("body").text());
                return builder.toString();
            } catch (IOException e) {
                e.printStackTrace();
                return "{\"message\" : \"error\" , \"error\" : \"" + e.getMessage() + "\"}";
            }
        }

        @Override
        protected void onPostExecute(String result) {
            try {
                GlobalVar.jsonObj = new JSONObject(result.toString());
                if(GlobalVar.jsonObj.getString("message").equals("error")){
                    GlobalVar.message = GlobalVar.jsonObj.getString("message");
                    GlobalVar.error =  GlobalVar.jsonObj.getString("error");
                }
                else if(GlobalVar.jsonObj.getString("message").equals("success")){
                    GlobalVar.message = GlobalVar.jsonObj.getString("message");
                    GlobalVar.rescue_team_current_task = GlobalVar.jsonObj.getString("rescue_team_current_task");
                    GlobalVar.DeviceLat = GlobalVar.jsonObj.getDouble("device_latitude");
                    GlobalVar.DeviceLong = GlobalVar.jsonObj.getDouble("device_longitude");
                }
                else{
                    GlobalVar.message = "error";
                    GlobalVar.error = "No json received.";
                }
            } catch (JSONException e) {
                e.printStackTrace();
                GlobalVar.message = "error";
                GlobalVar.error = e.getMessage();
            }
            super.onPostExecute(result);
            loading.setVisibility(View.INVISIBLE);
            if(GlobalVar.message.equals("error")){
                resultText.setText(GlobalVar.error);
            }
            else if(GlobalVar.message.equals("success")) {
                resultText.setText("");
                rescuerName.setText("Rescuer ID: " + GlobalVar.rescue_team_name);
                rescuerTask.setText("Rescuer ID: " + GlobalVar.rescue_team_current_task);
            }
        }
    }
}

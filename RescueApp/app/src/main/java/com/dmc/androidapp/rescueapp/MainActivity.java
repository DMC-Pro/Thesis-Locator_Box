package com.dmc.androidapp.rescueapp;

import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.support.v7.widget.Toolbar;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.widget.EditText;
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

    EditText latitude;
    EditText longitude;

    @Override
    protected void onCreate(Bundle savedInstanceState) {

        latitude = findViewById(R.id.editText4);
        longitude = findViewById(R.id.editText5);

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);
        // Get the SupportMapFragment and request notification
        // when the map is ready to be used.
        SupportMapFragment mapFragment = (SupportMapFragment) getSupportFragmentManager()
                .findFragmentById(R.id.map);
        mapFragment.getMapAsync(this);

        mTopToolbar = findViewById(R.id.my_toolbar);
        setSupportActionBar(mTopToolbar);

        findViewById(R.id.button3).setOnClickListener(
                new View.OnClickListener()
                {
                    public void onClick(View view)
                    {
                        GlobalVar.loclat = Double.parseDouble(latitude.getText().toString());
                        GlobalVar.loclong = Double.parseDouble(longitude.getText().toString());
                        changeMarker();
                    }
                }
        );

    }

    public void changeMarker(){
        GoogleMap googleMap = null;
        MarkerOptions a = new MarkerOptions()
                .position(new LatLng(GlobalVar.loclat, GlobalVar.loclong));
        Marker m = googleMap.addMarker(a);
        m.setPosition(new LatLng(GlobalVar.loclat, GlobalVar.loclong));
        LatLng device = new LatLng(GlobalVar.loclat, GlobalVar.loclong);
        googleMap.moveCamera(CameraUpdateFactory.newLatLng(device));
    }

    @Override
    public void onMapReady(GoogleMap googleMap) {
        //Proper values
        //  Positive Signed     Negative Signed
        //      North               South
        //      East                West
        //Example: 1°North 1°West is equal to (1, -1)
        LatLng device = new LatLng(14.6221, 121.0860);
        googleMap.addMarker(new MarkerOptions().position(device)
                .title("Marker to Device"));
        googleMap.moveCamera(CameraUpdateFactory.newLatLng(device));
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
            Toast.makeText(MainActivity.this, "Action clicked", Toast.LENGTH_LONG).show();
            return true;
        }

        return super.onOptionsItemSelected(item);
    }

}

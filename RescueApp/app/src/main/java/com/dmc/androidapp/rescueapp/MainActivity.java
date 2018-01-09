package com.dmc.androidapp.rescueapp;

import android.content.Intent;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        Intent splashIntent = new Intent(this, SplashScreen.class);
        startActivity(splashIntent);

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

    }
}

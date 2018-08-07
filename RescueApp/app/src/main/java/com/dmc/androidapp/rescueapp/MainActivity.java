package com.dmc.androidapp.rescueapp;

import android.os.Bundle;
import android.os.Handler;
import android.os.NetworkOnMainThreadException;
import android.support.v7.app.AppCompatActivity;
import android.widget.TextView;

import java.net.InetAddress;
import java.net.UnknownHostException;

public class MainActivity extends AppCompatActivity {

    @Override
    protected void onCreate(Bundle savedInstanceState) {
//        Intent loginIntent = new Intent(this, LoginActivity.class);
//        startActivity(loginIntent);

//        Intent splashIntent = new Intent(this, SplashActivity.class);
//        startActivity(splashIntent);

        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_main);

        Handler handler = new Handler();

        final TextView hostTextview =  findViewById(R.id.hostList);
        Thread thread = new Thread(new Runnable() {

            @Override
            public void run() {
                InetAddress ip;
                String host = "";
                try {
                    ip = InetAddress.getByAddress("192.168.8.100",);
                    host = "Current IP address : " + ip.getHostAddress();
                    hostTextview.setText(host);

                } catch (Exception e) {
                    hostTextview.setText("UnknownHostException");
                }
            }
        });

        thread.start();
//        new connection.getHostIP().execute();


    }
}

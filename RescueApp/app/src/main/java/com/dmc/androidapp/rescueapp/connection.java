package com.dmc.androidapp.rescueapp;

import android.os.AsyncTask;

import java.io.IOException;
import java.net.InetAddress;
import java.net.UnknownHostException;
import java.util.ArrayList;

/**
 * Created by DMC Pro on 23/05/2018.
 */

public class connection {

    public static ArrayList<String> ipList = new ArrayList<>();

    public static class getHostIP extends AsyncTask<Void, String, String> {

        @Override
        protected String doInBackground(Void... voids) {
            InetAddress ip;
            String host = "";
            try {
                ip = InetAddress.getLocalHost();
                host = "Current IP address : " + ip.getHostAddress();

            } catch (UnknownHostException e) {
                e.printStackTrace();

            }
            return host;
        }

        @Override
        protected void onPostExecute(String result) {
        }
    }

    public static class getHost extends AsyncTask<Void, String, Void> {
        String hostIP = "192.168.0.101";

        /*
        Scan IP 192.168.1.100~192.168.1.110
        you should try different timeout for your network/devices
         */
        static final String subnet = "192.168.8.";
        static final int lower = 100;
        static final int upper = 110;
        static final int timeout = 5000;

        @Override
        protected void onPreExecute() {
            ipList = null;
            // Toast.makeText(MainActivity.this, "Scan IP...", Toast.LENGTH_LONG).show();
        }

        @Override
        protected Void doInBackground(Void... params) {
            for (int i = lower; i <= upper; i++) {
                String host = subnet + i;

                try {
                    InetAddress inetAddress = InetAddress.getByName(host);
                    if (inetAddress.isReachable(timeout)){
                        publishProgress(inetAddress.toString());
                    }

                } catch (UnknownHostException e) {
                    e.printStackTrace();
                } catch (IOException e) {
                    e.printStackTrace();
                }
            }

            return null;
        }

        @Override
        protected void onProgressUpdate(String... values) {
            ipList.add(values[0]);
//             Toast.makeText(MainActivity.this, values[0], Toast.LENGTH_LONG).show();
        }

        @Override
        protected void onPostExecute(Void aVoid) {
             //Toast.makeText(MainActivity.this, "Done", Toast.LENGTH_LONG).show();
        }
    }

    private boolean testConnect(){
        /**
         * A connection to interface in the server in a form of php.
         * TODO: Create a connection setup here and return true on success.
         */

        return false;
    }

}

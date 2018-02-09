package com.dmc.androidapp.rescueapp;

import org.json.JSONObject;

/**
 * Created by DMC Pro on 09/01/2018.
 */

public class GlobalVar {
    public static String message = "none";
    public static String error = "none";
    public static double loclat = 14.6221;
    public static double loclong = 121.0860;
    public static String rescue_team_name;
    public static String rescue_team_current_task;
    public static String localhostwifi = "192.168.8.100";
    public static JSONObject jsonObj;
    // Rescuers Location Data
    public static String RescuerUsername;
    public static String RescuerLoc = "NotFound";
    public static double RescuerLat;
    public static double RescuerLong;
    // Device Location Data
    public static String DeviceLoc = "NotFound";
    public static double DeviceLat = 14.6221;
    public static double DeviceLong = 121.0860;

}

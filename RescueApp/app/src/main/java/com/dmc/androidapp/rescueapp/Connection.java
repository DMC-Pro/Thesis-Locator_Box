package com.dmc.androidapp.rescueapp;

import org.jsoup.Jsoup;
import org.jsoup.nodes.Document;
import org.jsoup.nodes.Element;
import org.jsoup.select.Elements;

import java.io.IOException;
import java.lang.Runnable;

/**
 * Created by DMC Pro on 19/01/2018.
 */

public class Connection {
    String data;
    public static String connect() throws IOException {
        Document doc = Jsoup.connect("http://192.168.8.101/thesis/conn/:8080").get();
        return doc.getElementsByTag("body").text();
    }
    //end of class
}

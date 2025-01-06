# Githubtest
using UnityEngine;
using UnityEngine.UI;
using UnityEngine.Events;
using System.Collections;
using System.Collections.Generic;

public class ClockManager : MonoBehaviour
{
    public Timer Timer;

    private Transform clockHandTransform;
    private const float realSecondsPerGameDay = 2f;
    private float day;

    private void Awake()
    {
        clockHandTransform = transform.Find("ClockHandImage");
        // ResetClockHand();
    }

    private void Update()
    {
        if (Timer.timeMoving == true)
        {
            day += Time.deltaTime / realSecondsPerGameDay;

            float dayNormalized = day % 1f;

            float rotationDegreesPerDay = 720;
            // clockHandTransform.eulerAngles = new Vector3(0, 0, -Time.realtimeSinceStartup * 90f);
            clockHandTransform.eulerAngles = new Vector3(0, 0, -dayNormalized * rotationDegreesPerDay);
        }
    }

    public void ResetClockHand()
    {
        clockHandTransform.eulerAngles = new Vector3(0, 0, 0);
    }
}
